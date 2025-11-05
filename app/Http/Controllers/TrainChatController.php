<?php

namespace App\Http\Controllers;

use App\Models\DuLieuChat;
use App\Models\Products;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;


class TrainChatController extends Controller
{
    private string $embedUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey   = env('GEIMINI_API_KEY'); // trùng tên biến bạn đang dùng
        $this->embedUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$this->apiKey}";
    }

    /** Train tất cả dữ liệu (static + sản phẩm + voucher) */
    public function trainAll(Request $request)
    {
        DB::beginTransaction();
        try {
            $p1 = $this->trainStatic($request, false);
            $p2 = $this->trainProducts($request, false);
            $p3 = $this->trainVouchers($request, false);
            DB::commit();

            return response()->json([
                'message' => '✅ Train xong!',
                'counts'  => [
                    'static'   => $p1['inserted'],
                    'products' => $p2['inserted'],
                    'vouchers' => $p3['inserted'],
                ],
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /** Train thông tin chung của shop */
    public function trainStatic(Request $request, bool $wrapResponse = true)
    {
        $items = [
            "SHOP CS403 chuyên bán laptop, điện thoại, máy tính bảng và phụ kiện chính hãng. Cam kết hàng mới 100%.",
            "Giờ làm việc: 08:00 - 21:00 mỗi ngày. Hotline: 0909 888 777. Email: support@shopcs403.com.",
            "Chính sách bảo hành: đổi trả trong 7 ngày nếu lỗi phần cứng, bảo hành tối thiểu 12 tháng tùy sản phẩm.",
            "Hỗ trợ giao hàng toàn quốc, thanh toán COD hoặc chuyển khoản.",
        ];

        $inserted = 0;
        foreach ($items as $text) {
            $inserted += $this->upsertEmbedding($text);
        }

        return $wrapResponse
            ? response()->json(['inserted' => $inserted])
            : ['inserted' => $inserted];
    }

    /** Train từ bảng products */
    public function trainProducts(Request $request, bool $wrapResponse = true)
    {
        $query = Products::query()->where('status', 'active');
        if ($request->filled('ids')) {
            $ids = array_filter(array_map('intval', explode(',', $request->input('ids'))));
            $query->whereIn('id', $ids);
        }

        $products = $query->get();
        $inserted = 0;

        foreach ($products as $p) {
            $specsText = '';
            if (!empty($p->specs)) {
                // specs là JSON -> gom thành văn bản ngắn gọn để tìm kiếm tốt
                $specs = is_array($p->specs) ? $p->specs : @json_decode($p->specs, true);
                if (is_array($specs)) {
                    foreach ($specs as $k => $v) $specsText .= "{$k}: {$v}; ";
                }
            }

            $text =
                "Sản phẩm: {$p->title}. ".
                "Thương hiệu: {$p->brand}. ".
                "Giá: ".number_format((float)$p->price, 0, ',', '.')." VND. ".
                "Bảo hành: {$p->warranty} tháng. ".
                (!empty($p->description) ? "Mô tả: {$p->description}. " : "").
                (!empty($specsText) ? "Thông số: {$specsText}" : "");

            $inserted += $this->upsertEmbedding($text);
        }

        return $wrapResponse
            ? response()->json(['inserted' => $inserted, 'total' => $products->count()])
            : ['inserted' => $inserted, 'total' => $products->count()];
    }

    /** Train từ bảng vouchers (nếu chưa có thì bạn giữ nguyên hoặc tạo bảng) */
    public function trainVouchers(Request $request, bool $wrapResponse = true)
    {
        if (!Schema::hasTable('vouchers')) {
            return $wrapResponse
                ? response()->json(['inserted' => 0, 'note' => 'Bảng vouchers chưa tồn tại'])
                : ['inserted' => 0];
        }

        $vouchers = Voucher::query()->get();
        $inserted = 0;

        foreach ($vouchers as $v) {
            $text =
                "Voucher: {$v->code}. ".
                "Mô tả: {$v->name}. ".
                "Giá trị: {$v->discount_value} ".($v->type === 'percent' ? 'phần trăm' : 'VND').". ".
                "Điều kiện: {$v->condition_text}. ".
                "Hiệu lực: từ {$v->start_date} đến {$v->end_date}. ".
                "Trạng thái: {$v->status}.";
            $inserted += $this->upsertEmbedding($text);
        }

        return $wrapResponse
            ? response()->json(['inserted' => $inserted, 'total' => $vouchers->count()])
            : ['inserted' => $inserted, 'total' => $vouchers->count()];
    }

    /** Tạo hoặc bỏ qua nếu trùng nội dung (hash) */
    private function upsertEmbedding(string $content): int
    {
        $hash = sha1(trim($content));
        $exists = DuLieuChat::where('hash', $hash)->exists();
        if ($exists) return 0;

        $embedding = $this->createEmbedding($content);
        if (!$embedding) return 0;

        DuLieuChat::create([
            'content'   => $content,
            'embedding' => json_encode($embedding),
            'hash'      => $hash,
        ]);

        // Tạm nghỉ nhẹ để tránh rate limit (nếu cần)
        usleep(120000); // 0.12s
        return 1;
    }

    /** Gọi Gemini Embedding API */
    private function createEmbedding(string $text): ?array
    {
        $res = Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($this->embedUrl, [
                'content' => ['parts' => [['text' => $text]]]
            ]);

        if (!$res->ok()) return null;
        return $res->json()['embedding']['values'] ?? null;
    }
}
