<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminDangNhapRequest;
use App\Http\Requests\capNhatAccountRequest;
use App\Http\Requests\capNhatCustomerRequest;
use App\Http\Requests\deleteAdminAccountRequest;
use App\Http\Requests\themAdminRequest;
use App\Http\Requests\themCustomerRequest;
use App\Http\Requests\xoaCustomerRequest;
use App\Models\AdminAccount;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AdminAccountController extends Controller
{
    public function getData(Request $request)
    {
        $data = AdminAccount::get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function getDataCustomer(Request $request)
    {
        $data = Customer::get();

        return response()->json([
            'data' => $data
        ]);
    }
    public function update(capNhatAccountRequest $request)
    {
        AdminAccount::find($request->id)->update([
            'ho_va_ten'   => $request->ho_va_ten,
            'email'       => $request->email,
            'password'    => $request->password,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'     => $request->dia_chi,
            'ngay_sinh'   => $request->ngay_sinh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã cập nhật tài khoản " . $request->ho_va_ten . " thành công.",
        ]);
    }

    public function delete(deleteAdminAccountRequest $request)
    {
        AdminAccount::find($request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa tài khoản thành công.",
        ]);
    }

    public function Login(AdminDangNhapRequest $request)
    {
        $check = AdminAccount::where('email', $request->email)
            ->where('password', $request->password)
            ->first();
        if ($check) {
            return response()->json([
                'status' => 1,
                'message' => "Đã đăng nhập thành công.",
                'token' => $check->createToken('token_admin')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Tài khoản hoặc mật khẩu của bạn không chính xác.",
            ]);
        }
    }

    public function checkToken()
    {
        $user_login = Auth::guard('sanctum')->user();
        if ($user_login) {
            return response()->json([
                'status' => 1,
                'ho_ten' => $user_login->ho_va_ten
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn cần đăng nhập hệ thống'
            ]);
        }
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
    public function create(themAdminRequest $request)
    {
        AdminAccount::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'email'         => $request->email,
            'password'      => $request->password,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã đăng ký tài khoản thành công.",
        ]);
    }
        public function createCustomer(themCustomerRequest $request)
    {
        Customer::create([
            'ho_va_ten'     => $request->ho_va_ten,
            'email'         => $request->email,
            'password'      => $request->password,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'       => $request->dia_chi,
            'ngay_sinh'     => $request->ngay_sinh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã đăng ký tài khoản thành công.",
        ]);
    }
     public function updateCustomer(capNhatCustomerRequest $request)
    {
        Customer::find($request->id)->update([
            'ho_va_ten'   => $request->ho_va_ten,
            'email'       => $request->email,
            'password'    => $request->password,
            'so_dien_thoai' => $request->so_dien_thoai,
            'dia_chi'     => $request->dia_chi,
            'ngay_sinh'   => $request->ngay_sinh,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã cập nhật tài khoản " . $request->ho_va_ten . " thành công.",
        ]);
    }

    public function deleteCustomer(xoaCustomerRequest $request)
    {
        Customer::find($request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa tài khoản thành công.",
        ]);
    }
}
