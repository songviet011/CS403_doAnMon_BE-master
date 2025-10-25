<?php

namespace App\Http\Controllers;

use App\Models\GioHang;
use App\Models\Products;
use App\Models\Orders;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GioHangController extends Controller
{
    // Thêm sản phẩm vào giỏ
    public function addToCart(Request $request)
    {
        try {
            $user = Auth::guard('sanctum')->user();
            if (!$user) return response()->json(['status' => false, 'message' => 'Bạn cần đăng nhập'], 401);

            $product = Products::find($request->product_id);
            if (!$product) return response()->json(['status' => false, 'message' => 'Sản phẩm không tồn tại'], 404);

            $cartItem = GioHang::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                $cartItem->quantity += $request->quantity ?? 1;
                $cartItem->save();
            } else {
                $cartItem = GioHang::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'hinh_anh' => $product->images,
                    'quantity' => $request->quantity ?? 1,
                    'price' => $product->price ?? 0,
                ]);
            }

            return response()->json(['status' => true, 'data' => $cartItem]);
        } catch (\Exception $e) {
            \Log::error('Lỗi addToCart: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Có lỗi xảy ra', 'error' => $e->getMessage()], 500);
        }
    }

    // Lấy danh sách giỏ hàng
    public function getCart()
    {
        $user = Auth::guard('sanctum')->user();
        $cartItems = GioHang::with('product')->where('user_id', $user->id)->get();

        return response()->json(['status' => true, 'data' => $cartItems]);
    }

    // Xoá sản phẩm
    public function removeFromCart($id)
    {
        $user = Auth::guard('sanctum')->user();
        $cartItem = GioHang::where('user_id', $user->id)->where('id', $id)->first();
        if ($cartItem) $cartItem->delete();

        return response()->json(['status' => true]);
    }

    // Tạo mã đơn hàng tự động
    private function generateOrderCode()
    {
        do {
            $lastOrder = Orders::orderBy('id', 'desc')->first();
            $nextNumber = 1;

            if ($lastOrder && $lastOrder->ma_don_hang) {
                $num = (int) preg_replace('/[^0-9]/', '', $lastOrder->ma_don_hang);
                $nextNumber = $num + 1;
            }

            $ma_don_hang = 'DH' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        } while (Orders::where('ma_don_hang', $ma_don_hang)->exists());

        return $ma_don_hang;
    }

    // Checkout giỏ hàng
    public function checkout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Bạn cần đăng nhập'], 401);
        }

        $items = $request->items;
        $voucherId = $request->voucher_id ?? null;

        if (empty($items)) {
            return response()->json(['status' => false, 'message' => 'Giỏ hàng trống'], 400);
        }

        $cartItems = GioHang::with('product')->where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Giỏ hàng trống'], 400);
        }

        // Lấy voucher nếu có
        $discount = 0;
        $voucher = null;
        if ($voucherId) {
            $voucher = Voucher::where('id', $voucherId)
                ->where('tinh_trang', 1)
                ->first();
            if ($voucher) {
                $discount = $voucher->loai_giam
                    ? 0 // tính sau khi tổng tiền tính xong (%)
                    : $voucher->so_giam_gia;
            }
        }

        $ordersCreated = [];

        foreach ($cartItems as $item) {
            $product = $item->product;
            $productTitle = $product->title ?? 'Sản phẩm';
            $productImage = $product->images ?? 'default.jpg';
            $price = $item->price ?? 0;

            $ma_don_hang = $this->generateOrderCode();

            // Tạm tính tổng tiền từng sản phẩm
            $tong_tien = $price * $item->quantity;

            // Nếu voucher giảm % thì tính dựa trên tổng tiền
            if ($voucher && $voucher->loai_giam) {
                $discount = $tong_tien * ($voucher->so_giam_gia / 100);
            }

            $tong_tien_sau_giam = max($tong_tien - $discount, 0);

            // Tạo đơn hàng
            $order = Orders::create([
                'id_khach_hang'  => $user->id,
                'ma_don_hang'    => $ma_don_hang,
                'hinh_anh'       => $productImage,
                'so_luong'       => $item->quantity,
                'ten_nguoi_nhan' => $user->ho_va_ten ?? 'Khách hàng',
                'so_dien_thoai'  => $user->so_dien_thoai ?? '',
                'tien_hang'      => $price,
                'tong_tien'      => $tong_tien_sau_giam,
                'voucher_id'     => $voucher?->id,
                'is_thanh_toan'  => 0,
                'tinh_trang'     => 2, // đang giao
            ]);
            $product->quantity = max($product->quantity - $item->quantity, 0);
            $product->save();
            $order = Orders::with(['customer', 'product'])->find($order->id);

            $ordersCreated[] = [
                'ma_don_hang'     => $order->ma_don_hang,
                'ten_khach_hang'  => $order->customer->ho_va_ten ?? 'Khách hàng',
                'so_dien_thoai'   => $order->customer->so_dien_thoai ?? '',
                'title'           => $productTitle,
                'hinh_anh'        => $productImage,
                'so_luong'        => $order->so_luong,
                'tien_hang'       => (float) $order->tien_hang,
                'tong_tien'       => (float) $order->tong_tien,
                'voucher_code'    => $voucher->ma_code ?? null,
                'ngay_dat'        => $order->created_at->format('d/m/Y'),
                'is_thanh_toan'   => $order->is_thanh_toan,
                'tinh_trang'      => $order->tinh_trang,
                'trang_thai_text' => match ($order->tinh_trang) {
                    0 => 'Đã hủy',
                    1 => 'Đã giao',
                    2 => 'Đang giao',
                    default => 'Không rõ',
                },
            ];
            $item->delete();
        }

        return response()->json([
            'status'  => true,
            'data'    => $ordersCreated,
            'message' => 'Đã tạo đơn hàng thành công và đang giao.',
        ]);
    }
    public function updateQuantity(Request $request, $id)
    {
        $user = Auth::guard('sanctum')->user();
        $cartItem = GioHang::where('user_id', $user->id)->where('id', $id)->first();
        if (!$cartItem) return response()->json(['status' => false, 'message' => 'Không tìm thấy sản phẩm'], 404);
        $product = $cartItem->product;
        $buyQty = min($request->quantity, $product->quantity);
        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return response()->json(['status' => true, 'data' => $cartItem]);
    }
}
