<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Log;

class SePayWebhookController extends Controller
{
    // Nhận webhook từ SePay
    public function handle(Request $request)
    {
        try {
            $data = $request->all();
            Log::info('SePay Webhook data: ', $data);

            // Chỉ xử lý tiền vào
            if (($data['transferType'] ?? null) === 'in' &&
                ($data['accountNumber'] ?? '') === '0866179631') {

                $ma_don_hang = $data['code'] ?? $this->layMaDonHang($data['description'] ?? '');

                if ($ma_don_hang) {
                    Orders::where('ma_don_hang', $ma_don_hang)
                          ->update(['is_thanh_toan' => 1]);
                    Log::info("Đơn hàng $ma_don_hang đã thanh toán.");
                } else {
                    Log::warning('Không tìm thấy mã đơn hàng trong webhook.');
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            Log::error('Lỗi webhook SePay: ' . $th->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    // Check trạng thái thanh toán
    public function checkStatus(Request $request)
    {
        $ma_don_hang = $request->input('code') ?? $request->input('ma_don_hang');
        if (!$ma_don_hang) return response()->json(['status'=>false,'message'=>'Thiếu mã đơn hàng'], 400);

        $donHang = Orders::where('ma_don_hang', $ma_don_hang)->first();
        if (!$donHang) return response()->json(['status'=>false,'message'=>'Đơn hàng không tồn tại'], 404);

        return response()->json([
            'status' => true,
            'paid'   => $donHang->is_thanh_toan == 1,
            'message'=> $donHang->is_thanh_toan ? 'Đã thanh toán' : 'Chưa thanh toán'
        ]);
    }

    private function layMaDonHang($text)
    {
        preg_match('/DH\d+/', $text, $matches);
        return $matches[0] ?? null;
    }
}
