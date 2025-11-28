<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ThanhToanController extends Controller
{
    /**
     * Tự động check giao dịch SePay và cập nhật trạng thái đơn hàng
     */
    public function pay(Request $request)
{
    $ma_don_hang = $request->input('ma_don_hang');

    if (!$ma_don_hang) {
        return response()->json([
            'status' => false,
            'paid'   => false,
            'message' => 'Thiếu thông tin mã đơn hàng'
        ]);
    }

    try {
        $client = new Client();
        
        $res = $client->post('https://api.sepay.vn/v1/bank/history', [
            'headers' => [
                'Authorization' => 'Apikey ' . config('sepay.api_key'),
                'Accept' => 'application/json',
            ],
            'json' => [
                'bank_account' => config('sepay.username'),
                'day_begin' => now()->format('d/m/Y'),
                'day_end'   => now()->format('d/m/Y'),
            ],
        ]);

        $data = json_decode($res->getBody(), true);
        $found = false;

        foreach ($data['data'] ?? [] as $tx) {

            // Lấy mã DHxxx từ nội dung chuyển khoản
            $tx_ma_don_hang = $this->layMaDonHang($tx['description'] ?? '');

            if ($tx_ma_don_hang === $ma_don_hang) {

                Orders::where('ma_don_hang', $ma_don_hang)
                    ->update(['is_thanh_toan' => 1]);

                $found = true;
                break;
            }
        }

        return response()->json([
            'status' => true,
            'paid'   => $found,
            'message' => $found ? 'Đơn hàng đã thanh toán' : 'Chưa tìm thấy giao dịch'
        ]);

    } catch (\Throwable $th) {

        Log::error('Lỗi SePay API: ' . $th->getMessage());

        return response()->json([
            'status' => false,
            'paid'   => false,
            'message' => 'Lỗi hệ thống'
        ]);
    }
}


    /** Lấy mã đơn hàng từ mô tả giao dịch */
    private function layMaDonHang($text)
    {
        preg_match('/DH\d+/', $text, $matches);
        return $matches[0] ?? null;
    }
}
