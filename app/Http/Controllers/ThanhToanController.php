<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ThanhToanController extends Controller
{
    /**
     * Tự động check giao dịch VPBank qua SePay và cập nhật trạng thái đơn hàng
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function pay(Request $request)
    {
        $ma_don_hang = $request->input('ma_don_hang'); // QR encode

    if (!$ma_don_hang) {
        return response()->json([
            'status' => 'error',
            'message' => 'Thiếu thông tin mã đơn hàng'
        ]);
    }

    try {
        $client = new Client();
        $res = $client->post('https://CyberLife.com/hooks/sepay-payment', [
            'headers' => [
                'Authorization' => 'Apikey ' . config('sepay.api_key'),
                'Accept' => 'application/json',
            ],
            'json' => [
                'NUMBER_VP' => config('sepay.username'),
                'DAY_BEGIN' => now()->format('d/m/Y'),
                'DAY_END' => now()->format('d/m/Y'),
            ],
        ]);

        $data = json_decode($res->getBody(), true);

        $found = false;

        foreach ($data['data']['transactionHistoryList'] ?? [] as $tx) {
            $tx_ma_don_hang = $this->layMaDonHang($tx['description'] ?? '');
            $tx_tong_tien  = $tx['creditAmount'] ?? 0;

            if ($tx_ma_don_hang === $ma_don_hang) {
                Orders::where('ma_don_hang', $ma_don_hang)
                    ->update(['is_thanh_toan' => 1]);
                $found = true;
                break;
            }
        }

        return response()->json([
            'status' => $found ? 'ok' : 'error',
            'message' => $found ? 'Đơn hàng đã thanh toán' : 'Không tìm thấy giao dịch phù hợp'
        ]);

    } catch (\Throwable $th) {
        Log::error('Lỗi SePay API: ' . $th->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Lỗi hệ thống, thử lại sau'
        ]);
    }
    }

    /**
     * Lấy mã đơn hàng từ mô tả giao dịch
     */
    private function layMaDonHang($text)
    {
        preg_match('/DH\d+/', $text, $matches);
        return $matches[0] ?? null;
    }
}
