<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\themCustomerRequest;
use App\Models\Customer;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class CustomerController extends Controller
{
     public function getData(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn chưa đăng nhập!',
            ], 401);
        }

        return response()->json([
            'status' => 1,
            'data' => $user
        ]);
    }
     public function getDataSanPham()
    {
        $data = Products::get();

        return response()->json([
            'data' => $data
        ]);
    }

     public function getDataOrders()
    {
        $data = Orders::get();

        return response()->json([
            'data' => $data
        ]);
    }
     public function getDataVoucher()
    {
        $check = Auth::guard('sanctum')->user();
        if ($check) {
            $data = Voucher::all();
            return response()->json([
                'data'      => $data
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        }
    }
    public function checkToken()
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            return response()->json([
                'status' => 1,
                'ho_ten' => $user->ho_va_ten,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn cần đăng nhập hệ thống.',
            ]);
        }
    }

    public function Login(CustomerRequest $request)
    {
        $customer = Customer::where('email', $request->email)->first();

        if (!$customer || $request->password !== $customer->password) {

            return response()->json([
                'status' => 0,
                'message' => "Tài khoản hoặc mật khẩu không chính xác."
            ], 401);
        }

        return response()->json([
            'status' => 1,
            'message' => "Đăng nhập thành công.",
            'token' => $customer->createToken('token_user')->plainTextToken,
        ]);
    }
    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            DB::table('personal_access_tokens')
                ->where('id', $user->currentAccessToken()->id)
                ->delete();
            return response()->json([
                'status'  => 1,
                'message' => "Đăng xuất thành công",
            ]);
        } else {
            return response()->json([
                'status'  => 0,
                'message' => "Có lỗi xảy ra",
            ]);
        }
    }
    public function getProfile(){
        $user = Auth::guard('sanctum')->user();
        if ($user) {
            return response()->json([
                'status' => 1,
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn cần đăng nhập hệ thống.',
            ]);
        }
    }
    public function create(themCustomerRequest $request)
    {
        Customer::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'email'         => $request->email,
            'password'      => $request->password,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'       => $request->ngay_sinh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã đăng ký tài khoản thành công.",
        ]);
    }
    public function thongKe(Request $request)
{
    $fromDate = $request->fromDate;
    $toDate   = $request->toDate;
    $customers = Customer::withCount('orders')
        ->withSum('orders', 'tong_tien')
        ->withMax('orders', 'tong_tien')
        ->whereBetween('created_at', [$fromDate, $toDate])
        ->get()
        ->map(function ($c) {
            return [
                'name'     => $c->ho_va_ten,
                'orders'   => $c->orders_count,
                'total'    => $c->orders_sum_tong_tien ?? 0,
                'maxOrder' => $c->orders_max_tong_tien ?? 0,
            ];
        });

    return response()->json([
        'status' => 1,
        'data'   => $customers
    ]);
}
 public function statistical(Request $request)
    {
        $from = $request->query('from') ?? '2000-01-01';
        $to = $request->query('to') ?? now()->format('Y-m-d');

        $data = DB::table('orders')
            ->select('id_khach_hang', 'ten_nguoi_nhan', DB::raw('COUNT(*) as orders'), DB::raw('SUM(tong_tien) as total'), DB::raw('MAX(tong_tien) as maxOrder'))
            ->whereBetween('created_at', [$from.' 00:00:00', $to.' 23:59:59'])
            ->groupBy('id_khach_hang', 'ten_nguoi_nhan')
            ->orderBy('total', 'desc')
            ->get();

        return response()->json(['data' => $data]);
    }
     public function updateProfile(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = Customer::find($user->id);
        if ($data) {
            $data->update([
                'ho_va_ten'     => $request->ho_va_ten,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email'         => $request->email,
                'dia_chi'       => $request->dia_chi,
            ]);
            return response()->json([
                'status'    => 1,
                'message'   => 'Cập nhật thông tin thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Cập nhật thông tin thất bại!',
            ]);
        }
    }
     public function updatePassword(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        $data = Customer::where('id', $user->id)
            ->where('password', $request->old_password)
            ->first();
        if ($data) {
            $data->update([
                'password' => $request->password,
            ]);
            return response()->json([
                'status'    => 1,
                'message'   => 'Cập nhật mật khẩu thành công!',
            ]);
        } else {
            return response()->json([
                'status'    => 0,
                'message'   => 'Mật khẩu cũ không đúng!',
            ]);
        }
    }
     public function pay(){
        $client = new \GuzzleHttp\Client();
        $payload = [
                "USERNAME"  => "0905799210",
                "PASSWORD"  => "",
                "DAY_BEGIN" => Carbon::today()->format("d/m/Y"),
                "DAY_END"   => Carbon::today()->format("d/m/Y"),
                "NUMBER_MB" => "0905799210"
        ];
        try{
            $res = $client->post("https://api-mb.dzmid.io.vn/api/transactions", [
                'json' => $payload,
            ]);
            $data = json_decode($res->getBody(),true);
            foreach($data['data']['transactionHistoryList'] as $key => $value){
                $ma_don_hang = $this->layMaDonHang($value["description"]);
                $tong_tien = $value["creditAmount"];
                Orders::where('ma_don_hang',$ma_don_hang)
                ->where('tong_tien',$tong_tien)
                ->update([
                    'is_thanh_toan' => 1
                ]);

            }
        }
        catch(\Throwable $th){

        }
    }
    function layMaDonHang($text) {
        preg_match('/DH\d+/', $text, $matches);
        return $matches[0] ?? null;
    }
}
