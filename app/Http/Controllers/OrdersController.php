<?php

namespace App\Http\Controllers;

use App\Http\Requests\deleteOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    public function getData()
    {
        $data = Orders::all();

        return response()->json([
            'status' => true,
            'data'   => $data
        ]);
    }

    public function getDonHangKhachHang()
    {
        $user = Auth::guard('sanctum')->user();
        $data = Orders::where('id_khach_hang', $user->id)
            ->select(
                'id',
                'ma_don_hang',
                'hinh_anh',
                'so_luong',
                'ten_nguoi_nhan',
                'so_dien_thoai',
                'tien_hang',
                'tong_tien',
                'is_thanh_toan',
                'tinh_trang',
                'created_at'
            )
            ->get();
        return response()->json([
            'status' => true,
            'data'      => $data
        ]);
    }
    public function delete(deleteOrderRequest $request)
    {
        $order = Orders::find($request->id);

        if (!$order) {
            return response()->json([
                'status'  => false,
                'message' => 'Không tìm thấy đơn hàng để xoá.'
            ], 404);
        }

        $order->delete();

        return response()->json([
            'status'  => true,
            'message' => "Đã xóa đơn hàng thành công."
        ]);
    }

    public function show($id)
    {
        $order = Orders::find($id);

        if (!$order) {
            return response()->json([
                'status'  => false,
                'message' => 'Không tìm thấy đơn hàng.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data'   => $order
        ]);
    }
    private function generateOrderCode()
    {
        do {
            $lastOrder = Orders::orderBy('id', 'desc')->first();
            $nextNumber = 1;

            if ($lastOrder && $lastOrder->ma_don_hang) {
                $num = (int) preg_replace('/[^0-9]/', '', $lastOrder->ma_don_hang);
                $nextNumber = $num + 1;
            }

            $ma_don_hang = '#DH' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

            // Nếu trùng thì tăng nextNumber
        } while (Orders::where('ma_don_hang', $ma_don_hang)->exists());

        return $ma_don_hang;
    }

public function getNewOrderCode()
{
    $lastOrder = Orders::orderBy('id', 'desc')->first();

    if ($lastOrder) {
        // Giả sử mã dạng DHxxx
        $lastNumber = (int)substr($lastOrder->ma_don_hang, 2);
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    $newCode = 'DH' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    return response()->json([
        'status' => true,
        'new_code' => $newCode
    ]);
}

    public function store(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'Bạn cần đăng nhập'], 401);
            }

            $items = $request->input('items', []);
            if (empty($items)) {
                return response()->json(['status' => false, 'message' => 'Không có sản phẩm nào để đặt'], 400);
            }

            $ordersCreated = [];

            foreach ($items as $item) {
                // Kiểm tra product_id có tồn tại
                if (!isset($item['product_id']) || !isset($item['quantity'])) {
                    Log::warning('Item thiếu product_id hoặc quantity', $item);
                    continue;
                }

                $product = Products::find($item['product_id']);
                if (!$product) {
                    Log::warning('Sản phẩm không tồn tại', $item);
                    continue;
                }

                // Kiểm tra đơn hàng tồn tại chưa
                $existingOrder = Orders::where('id_khach_hang', $user->id)
                    ->whereNull('id_voucher')
                    ->where('tinh_trang', 'Chưa xử lý')
                    ->where('hinh_anh', $product->images)
                    ->first();

                if ($existingOrder) {
                    $existingOrder->so_luong += $item['quantity'];
                    $existingOrder->tong_tien = $existingOrder->tien_hang * $existingOrder->so_luong;
                    $existingOrder->save();
                    $ordersCreated[] = $existingOrder;
                } else {
                    $ma_don_hang = $this->generateOrderCode();

                    $order = Orders::create([
                        'id_khach_hang'  => $user->id,
                        'ma_don_hang'    => $ma_don_hang,
                        'hinh_anh'       => $product->images,
                        'so_luong'       => $item['quantity'],
                        'ten_nguoi_nhan' => $user->name ?? 'Khách hàng',
                        'so_dien_thoai'  => $user->phone ?? '',
                        'tien_hang'      => $product->price ?? 0,
                        'tong_tien'      => ($product->price ?? 0) * $item['quantity'],
                        'is_thanh_toan'  => false,
                        'tinh_trang'     => 0,
                    ]);

                    $ordersCreated[] = $order;
                }
            }

            if (empty($ordersCreated)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể tạo đơn hàng, kiểm tra sản phẩm.'
                ], 400);
            }

            return response()->json([
                'status'  => true,
                'data'    => $ordersCreated,
                'message' => 'Sản phẩm đã được thêm vào giỏ hàng thành công.'
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm giỏ hàng', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'status' => false,
                'message' => 'Có lỗi xảy ra khi thêm giỏ hàng.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
   public function update(UpdateOrderRequest $request)
{
    // Lấy đơn hàng theo ID từ request (nếu có gửi)
    $order = Orders::find($request->id);

    if (!$order) {
        return response()->json([
            'status'  => false,
            'message' => 'Không tìm thấy đơn hàng.'
        ], 404);
    }

    // Cập nhật các thông tin cho phép sửa
    $order->update([
        'ten_nguoi_nhan' => $request->ten_nguoi_nhan,
        'so_dien_thoai'  => $request->so_dien_thoai,
        'tinh_trang'     => $request->tinh_trang,
        'is_thanh_toan'  => $request->is_thanh_toan,
        'tong_tien'      => $request->tong_tien,
    ]);

    return response()->json([
        'status'  => true,
        'data'    => $order,
        'message' => 'Cập nhật đơn hàng thành công.'
    ]);
}
 public function getChiTietDonHangKhachHang(Request $request)
    {
        $data = Orders::where('orders.id', $request->id)
            ->join('customers', 'customers.id', 'orders.id_khach_hang')
            ->select(
                'orders.ten_nguoi_nhan',
                'customers.so_dien_thoai',
                'customers.dia_chi',
                'orders.so_luong',
                'orders.ma_don_hang',
                'orders.tien_hang',
                'orders.tong_tien',
            )
            ->first();
        return response()->json([
        'status' => true,
        'data'  => $data
        ]);
    }
}
