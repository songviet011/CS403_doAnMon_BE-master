<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\DuLieuChat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DuLieuChatSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Giới thiệu chung
            "CyberLife là nền tảng thương mại điện tử chuyên cung cấp robot và thiết bị gia dụng thông minh.",
            "Sứ mệnh của CyberLife là mang công nghệ tiên tiến đến mọi gia đình Việt Nam.",
            "CyberLife cam kết mang đến sản phẩm chính hãng, chất lượng cao và giá cả cạnh tranh.",
            "Mọi sản phẩm tại CyberLife đều được nhập khẩu chính ngạch, có giấy tờ bảo hành rõ ràng.",
            "CyberLife hoạt động hợp pháp theo quy định của pháp luật Việt Nam.",

            // Sản phẩm
            "CyberLife cung cấp robot hút bụi, robot lau nhà, máy lọc không khí và thiết bị nhà thông minh.",
            "Mỗi sản phẩm đều có thông tin chi tiết về tính năng, xuất xứ và hướng dẫn sử dụng.",
            "Sản phẩm tại CyberLife luôn được cập nhật mẫu mới và công nghệ mới nhất trên thị trường.",
            "CyberLife hợp tác với các thương hiệu uy tín như Roborock, Ecovacs, Dreame và Xiaomi.",
            "Các sản phẩm đều được kiểm tra kỹ lưỡng trước khi giao đến tay khách hàng.",

            // Giao hàng
            "CyberLife giao hàng toàn quốc thông qua các đơn vị vận chuyển uy tín như Giao Hàng Nhanh và Viettel Post.",
            "Thời gian giao hàng trung bình từ 2 đến 5 ngày làm việc tùy theo khu vực.",
            "Khách hàng ở nội thành có thể nhận hàng trong ngày nếu đặt trước 12h trưa.",
            "Phí giao hàng được hiển thị rõ ràng trước khi thanh toán.",
            "CyberLife miễn phí vận chuyển cho đơn hàng từ 1.000.000đ trở lên.",

            // Đổi trả & bảo hành
            "Khách hàng có thể đổi hoặc trả hàng trong vòng 7 ngày nếu sản phẩm bị lỗi hoặc không đúng mô tả.",
            "CyberLife hỗ trợ bảo hành sản phẩm trong 12 tháng kể từ ngày mua.",
            "Nếu sản phẩm lỗi do nhà sản xuất, CyberLife sẽ chịu toàn bộ chi phí đổi trả.",
            "Chính sách đổi trả chỉ áp dụng cho sản phẩm còn nguyên vẹn và đầy đủ phụ kiện.",
            "Khách hàng cần cung cấp hóa đơn hoặc mã đơn hàng khi yêu cầu đổi trả.",

            // Thanh toán
            "CyberLife hỗ trợ thanh toán qua thẻ ATM, Visa, MasterCard, ví Momo, ZaloPay hoặc tiền mặt khi nhận hàng.",
            "Tất cả giao dịch thanh toán đều được mã hóa để đảm bảo an toàn tuyệt đối.",
            "Hệ thống thanh toán của CyberLife tuân thủ tiêu chuẩn bảo mật PCI DSS quốc tế.",
            "Sau khi thanh toán thành công, khách hàng sẽ nhận được hóa đơn điện tử qua email.",
            "CyberLife hỗ trợ thanh toán trả góp với lãi suất 0% qua các ngân hàng đối tác.",

            // Khuyến mãi & ưu đãi
            "CyberLife thường xuyên có các chương trình giảm giá và tặng quà vào dịp lễ, Tết.",
            "Khách hàng đăng ký tài khoản lần đầu được giảm 10% cho đơn hàng đầu tiên.",
            "CyberLife có chương trình khách hàng thân thiết với điểm thưởng đổi quà.",
            "Mã giảm giá được áp dụng trực tiếp tại bước thanh toán.",
            "CyberLife tổ chức các sự kiện livestream giới thiệu sản phẩm mới và khuyến mãi đặc biệt.",

            // Hỗ trợ & tài khoản
            "Khách hàng có thể liên hệ hỗ trợ qua hotline 1900 1234, chat trực tuyến hoặc email support@cyberlife.vn.",
            "Đội ngũ hỗ trợ kỹ thuật làm việc từ 8h sáng đến 10h tối tất cả các ngày trong tuần.",
            "Khách hàng có thể tra cứu tình trạng đơn hàng trong mục 'Đơn hàng của tôi'.",
            "CyberLife cho phép khách hàng thay đổi mật khẩu, địa chỉ giao hàng và thông tin cá nhân bất cứ lúc nào.",
            "Tài khoản CyberLife giúp người dùng lưu lại lịch sử mua hàng và tích điểm ưu đãi.",

            // Bảo mật & quyền riêng tư
            "CyberLife cam kết bảo mật tuyệt đối thông tin cá nhân của khách hàng.",
            "Dữ liệu người dùng được lưu trữ bằng công nghệ mã hóa hiện đại và không chia sẻ cho bên thứ ba.",
            "CyberLife chỉ sử dụng thông tin người dùng để xử lý đơn hàng và chăm sóc khách hàng.",
            "Khách hàng có thể yêu cầu xóa tài khoản và dữ liệu cá nhân bất kỳ lúc nào.",

            // Hóa đơn & chứng từ
            "CyberLife cung cấp hóa đơn VAT cho tất cả các đơn hàng theo yêu cầu của khách hàng.",
            "Khách hàng cần cung cấp mã số thuế khi yêu cầu xuất hóa đơn.",
            "Hóa đơn điện tử được gửi qua email trong vòng 24 giờ sau khi đơn hàng được xác nhận.",

            // Kỹ thuật & cài đặt
            "CyberLife cung cấp dịch vụ lắp đặt robot tận nhà cho khách hàng tại khu vực nội thành.",
            "Hướng dẫn sử dụng chi tiết được đính kèm trong hộp sản phẩm hoặc tải từ trang sản phẩm.",
            "Khách hàng có thể yêu cầu nhân viên kỹ thuật hỗ trợ cấu hình robot qua video call.",

            // Tin tức & truyền thông
            "Mục 'Tin tức' trên CyberLife cập nhật xu hướng và công nghệ mới nhất về robot và AI.",
            "CyberLife chia sẻ mẹo sử dụng robot hiệu quả và tiết kiệm điện năng.",
            "CyberLife có kênh YouTube hướng dẫn sử dụng và bảo dưỡng sản phẩm.",
            "Khách hàng có thể đăng ký nhận bản tin để cập nhật khuyến mãi và sản phẩm mới.",
        ];

        //  Products
        $products = DB::table('products')->get();
        foreach ($products as $p) {
            $text = "{$p->title} ({$p->brand}): {$p->description}, Giá: {$p->price}đ, Bảo hành: {$p->warranty} tháng.";
            $specs = json_decode($p->specs, true);
            if ($specs) {
                $specText = implode(", ", array_map(fn($k, $v) => "$k: $v", array_keys($specs), $specs));
                $text .= " Thông số kỹ thuật: {$specText}.";
            }
            $data[] = $text;
        }

        //  Vouchers
        $vouchers = DB::table('vouchers')->get();
        foreach ($vouchers as $v) {
            $type = $v->loai_giam == 1 ? "% giảm" : "giảm cố định";
            $text = "Voucher '{$v->ten_voucher}' mã '{$v->ma_code}' áp dụng cho sản phẩm ID {$v->id_san_pham}, {$type} {$v->so_giam_gia}" .
                ($v->loai_giam == 1 ? "%" : "đ") .
                ", tối đa {$v->so_tien_toi_da}đ, đơn tối thiểu {$v->don_hang_toi_thieu}đ, từ {$v->thoi_gian_bat_dau} đến {$v->thoi_gian_ket_thuc}.";
            $data[] = $text;
        }
        echo "Đã gom tổng cộng " . count($data) . " dòng dữ liệu để huấn luyện.\n";


        $apiKey = env('GEIMINI_API_KEY');
        foreach ($data as $content) {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-embedding-001:embedContent?key={$apiKey}", [
                "model" => "embedding-001",
                'content' => [
                    'parts' => [
                        ['text' => $content]
                    ]
                ]
            ]);

            $json = $response->json();

            if (isset($json['embedding']['values'])) {
                DuLieuChat::create([
                    'content' => $content,
                    'embedding' => json_encode($json['embedding']['values']),
                ]);
            } else {
                echo "Lỗi khi tạo embedding cho: {$content}\n";
                print_r($json);
            }
        }

        echo "\nĐã seed dữ liệu chatbot bằng Gemini thành công!\n";
    }
}
