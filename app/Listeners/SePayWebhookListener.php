<?php

namespace App\Listeners;

use App\Models\User;
use SePay\SePay\Events\SePayWebhookEvent;
use SePay\SePay\Notifications\SePayTopUpSuccessNotification;

class SePayWebhookListener
{
    public function handle(SePayWebhookEvent $event): void
    {
        // Lấy data từ event
        $data = $event->info;

        // Nếu là JSON string, decode ra array
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        // Kiểm tra kiểu giao dịch 'in' (nạp tiền)
        if (isset($data['transferType']) && $data['transferType'] === 'in') {
            $userId = $data['user_id'] ?? null; // Hoặc lấy ID phù hợp từ dữ liệu
            if ($userId && $user = User::find($userId)) {
                $user->notify(new SePayTopUpSuccessNotification($data));
            }
        }
    }
}
