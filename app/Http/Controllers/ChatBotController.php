<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\DuLieuChat;

class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['error' => 'No message provided'], 400);
        }

        try {
            $apiKey = env('GEIMINI_API_KEY');

            $embeddingResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
                'content' => [
                    'parts' => [
                        ['text' => $message]
                    ]
                ]
            ]);

            $embeddingData = $embeddingResponse->json();
            $userEmbedding = $embeddingData['embedding']['values'] ?? null;

            if (!$userEmbedding) {
                return response()->json(['error' => 'Không tạo được embedding từ câu hỏi'], 500);
            }

            $ranked = [];

            foreach (DuLieuChat::all() as $item) {
                $dataEmbedding = json_decode($item->embedding, true);
                if (!$dataEmbedding) continue;

                $dot = 0;
                $normA = 0;
                $normB = 0;

                foreach ($userEmbedding as $i => $v) {
                    $dot += $v * ($dataEmbedding[$i] ?? 0);
                    $normA += $v ** 2;
                    $normB += ($dataEmbedding[$i] ?? 0) ** 2;
                }

                $cosine = $dot / (sqrt($normA) * sqrt($normB));
                $ranked[] = [
                    'content' => $item->content,
                    'score' => $cosine
                ];
            }

            usort($ranked, fn($a, $b) => $b['score'] <=> $a['score']);
            $topMatches = array_slice($ranked, 0, 5);
            $bestMatch = $topMatches[0]['content'] ?? null;
            $bestScore = isset($topMatches[0]['score']) ? floatval($topMatches[0]['score']) : null;
            $context = implode("\n", array_column($topMatches, 'content'));
<<<<<<< HEAD
            $prompt = "Dưới đây là thông tin nội bộ của website SHOP CS403:\n{$context}\n\n"
                . "Người dùng hỏi: {$message}\n"
                . "Bạn là một nhân viên tư vấn thông minh của SHOP CS403, nhiệm vụ là trả lời câu hỏi khách hàng dựa trên dữ liệu nội bộ. "
=======
            $prompt = "Dưới đây là thông tin nội bộ của website CyberLife:\n{$context}\n\n"
                . "Người dùng hỏi: {$message}\n"
                . "Bạn là một nhân viên tư vấn thông minh của CyberLife, nhiệm vụ là trả lời câu hỏi khách hàng dựa trên dữ liệu nội bộ. "
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
                . "Hãy trả lời theo các hướng dẫn sau:\n\n"
                . "1. **Ưu tiên thông tin thực tế và đầy đủ**:\n"
                . "   - Nếu câu hỏi liên quan đến voucher, hãy trả lời đầy đủ: tên voucher, giá trị giảm, điều kiện áp dụng, hạn sử dụng.\n"
                . "   - Nếu câu hỏi về sản phẩm, hãy trả lời: tên sản phẩm, giá, giá cũ nếu có, mô tả ngắn gọn, khuyến mãi nếu có.\n"
                . "2. **Gộp thông tin liên quan thành câu trả lời duy nhất**:\n"
                . "   - Nếu có nhiều dòng dữ liệu liên quan, hãy kết hợp chúng thành một đoạn văn tự nhiên, mạch lạc, không tách rời.\n"
                . "3. **Xử lý từ đồng nghĩa hoặc lỗi chính tả**:\n"
                . "   - Xử lý tất cả các biến thể của từ khóa: ví dụ 'boucher', 'vourcher', 'voucher', 'mã giảm giá', 'phiếu giảm giá' → hiểu là voucher.\n"
                . "   - Nếu người dùng viết sai chính tả hoặc viết tắt, hãy tự động chuyển sang từ đúng trước khi tìm dữ liệu.\n"
                . "4. **Thân thiện, ngắn gọn và dễ hiểu**:\n"
                . "   - Viết như nhân viên tư vấn trực tiếp, không dùng thuật ngữ kỹ thuật, tránh trả text rời rạc.\n"
                . "5. **Ưu tiên các thông tin quan trọng, tránh trả thông tin không cần thiết**:\n"
                . "   - Chỉ dùng hình ảnh minh họa nếu không còn thông tin thực tế.\n"
                . "6. **Nếu không tìm thấy dữ liệu liên quan**:\n"
                . "   - Hãy trả lời lịch sự: 'Xin lỗi, hiện tại tôi chưa có thông tin về điều đó.'\n"
                . "7. **Định dạng trả lời**:\n"
                . "   - Chỉ trả text hoàn chỉnh, không trả JSON hay code.\n"
                . "   - Nếu có nhiều thông tin, hãy chia câu hợp lý để dễ đọc.\n"
                . "8. **Tối ưu trải nghiệm khách hàng**:\n"
                . "   - Trả lời đầy đủ nhưng không quá dài.\n"
                . "   - Nếu câu hỏi không rõ ràng, cố gắng hỏi lại một cách lịch sự hoặc trả lời thông tin liên quan nhất.\n\n"
                . "Hãy trả lời câu hỏi của người dùng dựa trên dữ liệu nội bộ một cách chính xác, liên quan, tự nhiên và thân thiện.";

            $apiResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            $responseData = $apiResponse->json();
            $reply = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if ($reply) {
                return response()->json([
                    'reply' => $reply,
                    'match' => $bestMatch,
                    'score' => round($bestScore, 3)
                ]);
            } else {
                return response()->json([
                    'error' => 'Không có phản hồi từ Gemini',
                    'raw' => $responseData
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'API request failed',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
