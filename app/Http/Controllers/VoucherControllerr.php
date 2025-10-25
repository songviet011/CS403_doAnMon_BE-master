<?php

namespace App\Http\Controllers;

use App\Http\Requests\capNhatVoucherRequest;
use App\Http\Requests\themVoucherRequest;
use App\Http\Requests\xoaVoucherRequest;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherControllerr extends Controller
{
    public function getData(Request $request)
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
    public function createVoucher(themVoucherRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        } else {
            Voucher::create([
                'ma_code'               => $request->ma_code,
                'ten_voucher'           => $request->ten_voucher,
                'hinh_anh'              => $request->hinh_anh,
                'thoi_gian_bat_dau'     => $request->thoi_gian_bat_dau,
                'thoi_gian_ket_thuc'    => $request->thoi_gian_ket_thuc,
                'loai_giam'             => $request->loai_giam,
                'so_giam_gia'           => $request->so_giam_gia,
                'id_san_pham'           => $user->id,
                'so_tien_toi_da'        => $request->so_tien_toi_da,
                'don_hang_toi_thieu'    => $request->don_hang_toi_thieu,
            ]);

            return response()->json([
                'status'    => 1,
                'message'   => 'Thêm voucher thành công!',
            ]);
        }
    }

    public function updateVoucher(capNhatVoucherRequest $request)
    {
        $user = Auth::guard('sanctum')->user();
        if (!$user) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        } else {
            Voucher::find($request->id)->update([
                'ma_code'               => $request->ma_code,
                'ten_voucher'           => $request->ten_voucher,
                'hinh_anh'              => $request->hinh_anh,
                'thoi_gian_bat_dau'     => $request->thoi_gian_bat_dau,
                'thoi_gian_ket_thuc'    => $request->thoi_gian_ket_thuc,
                'loai_giam'             => $request->loai_giam,
                'so_giam_gia'           => $request->so_giam_gia,
                'id_san_pham'           => $user->id,
                'so_tien_toi_da'        => $request->so_tien_toi_da,
                'don_hang_toi_thieu'    => $request->don_hang_toi_thieu,
            ]);

            return response()->json([
                'status'    => 1,
                'message'   => 'Cập nhật voucher thành công!',
            ]);
        }
    }

    public function deleteVoucher(xoaVoucherRequest $request)
    {
        $check = Auth::guard('sanctum')->user();
        if (!$check) {
            return response()->json([
                'status'    => 0,
                'message'   => 'Bạn cần đăng nhập hệ thống!'
            ]);
        } else {
            $data = Voucher::find($request->id);
            if ($data) {
                $data->delete();
                return response()->json([
                    'status'    => 1,
                    'message'   => 'Xóa Voucher thành công!',
                ]);
            } else {
                return response()->json([
                    'status'    => 0,
                    'message'   => 'Voucher không tồn tại!',
                ]);
            }
        }
    }
    public function VouCherUser()
    {
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            return response()->json([
                'status' => 0,
                'message' => 'Bạn cần đăng nhập!'
            ]);
        }

        $vouchers = Voucher::where('tinh_trang', 1)
            ->get()
            ->filter(function ($v) use ($user) {
                $vu = $v->users()->where('user_id', $user->id)->first();
                return !$vu || $vu->pivot->so_lan_da_dung < 2;
            })
            ->take(5);

        return response()->json([
            'status' => 1,
            'data' => $vouchers
        ]);
    }
}
