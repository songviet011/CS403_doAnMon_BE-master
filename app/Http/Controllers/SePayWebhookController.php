<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use Illuminate\Support\Facades\Log;

class SePayWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            // 1. Kiểm tra API Key
            $apiKeySePay = env('SEPAY_WEBHOOK_TOKEN');
            $authorizationHeader = $request->header('Authorization', '');

            if ($authorizationHeader !== "Apikey $apiKeySePay") {
                Log::warning('SePay Webhook: Unauthorized request.');
                return response()->json(['status' => 'unauthorized'], 401);
            }

            $data = $request->all();
            Log::info('SePay Webhook data: ', $data);

            // 3. Chỉ xử lý giao dịch tiền vào
            if (($data['transferType'] ?? null) === 'in' &&
                ($data['accountNumber'] ?? '') === '0905799210'
            ) {

                $ma_don_hang = $data['code'] ?? $this->layMaDonHang($data['description'] ?? '');

                if ($ma_don_hang) {
                    $updated = Orders::where('ma_don_hang', $ma_don_hang)
                        ->update(['is_thanh_toan' => 1]);

                    if ($updated) {
                        Log::info("Đơn hàng $ma_don_hang đã được cập nhật thanh toán.");
                    } else {
                        Log::warning("Đơn hàng $ma_don_hang không tồn tại hoặc đã thanh toán.");
                    }
                } else {
                    Log::warning('SePay Webhook: Không tìm thấy mã đơn hàng trong description.');
                }
            } else {
                Log::info('SePay Webhook: Giao dịch không phải tiền vào VPBank hoặc dữ liệu không hợp lệ.');
            }

            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            Log::error('Lỗi xử lý Webhook SePay: ' . $th->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function checkStatus(Request $request)
    {
        // Nhận code hoặc ma_don_hang đều được
        $ma_don_hang = $request->input('ma_don_hang') ?? $request->input('code');

        if (!$ma_don_hang) {
            return response()->json([
                'status' => false,
                'message' => 'Thiếu mã đơn hàng'
            ], 400);
        }

        $donHang = Orders::where('ma_don_hang', $ma_don_hang)->first();

        if (!$donHang) {
            return response()->json([
                'status' => false,
                'message' => 'Đơn hàng không tồn tại'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'paid' => $donHang->is_thanh_toan == 1,
            'message' => $donHang->is_thanh_toan == 1 ? 'Đã thanh toán' : 'Chưa thanh toán',
        ]);
    }

    private function layMaDonHang($text)
    {
        preg_match('/DH\d+/', $text, $matches);
        return $matches[0] ?? null;
    }
}
