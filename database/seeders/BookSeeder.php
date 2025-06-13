<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Book::create([
            'title' => 'Đắc Nhân Tâm (Bìa cứng)',
            'description' => 'Đắc Nhân Tâm (Bìa cứng)

                Đắc Nhân Tâm của Dale Carnegie là quyển sách duy nhất về thể loại self-help liên tục đứng đầu danh mục sách bán chạy nhất (best-selling Books) do báo The New York Times bình chọn suốt 10 năm liền. Được xuất bản năm 1936, với số lượng bán ra hơn 15 triệu bản, tính đến nay, sách đã được dịch ra ở hầu hết các ngôn ngữ, trong đó có cả Việt Nam, và đã nhận được sự đón tiếp nhiệt tình của đọc giả ở hầu hết các quốc gia.

                Là quyển sách đầu tiên có ảnh hưởng làm thay đổi cuộc đời của hàng triệu người trên thế giới, Đắc Nhân Tâm là cuốn sách đem lại những giá trị tuyệt vời cho người đọc, bao gồm những lời khuyên cực kì bổ ích về cách ứng xử trong cuộc sống hàng ngày. Sức lan toả của quyển sách vô cùng rộng lớn – với nhiều tầng lớp, đối tượng.

                Đắc Nhân Tâm không chỉ là là nghệ thuật thu phục lòng người, Đắc Nhân Tâm còn đem lại cho độc giả góc nhìn, suy nghĩ sâu sắc về việc giao tiếp ứng xử.

                Triết lý của Đắc Nhân Tâm là  hiểu mình, thành thật với chính mình, từ đó hiểu biết và quan tâm đến những người xung quanh để nhìn ra và khơi gợi những tiềm năng ẩn khuất nơi họ, giúp họ phát triển lên một tầm cao mới. Đây chính là nghệ thuật cao nhất về con người và chính là ý nghĩa sâu sắc nhất đúc kết từ những nguyên tắc vàng của Dale Carnegie.

                Một số nguyên tắc – Nghệ thuật ứng xử căn bản:

                Nguyên tắc 1: Không chỉ trích, oán trách hay than phiền.
                Nguyên tắc 2: Thành thật khen ngợi và biết ơn người khác.
                Nguyên tắc 3: Gợi cho người khác ý muốn thực hiện điều bạn muốn họ làm.
                6 cách tạo thiện cảm:

                Nguyên tắc 4: Thật lòng quan tâm đến người khác.
                Nguyên tắc 5: Hãy mỉm cười!
                Nguyên tắc 6: Luôn nhớ rằng tên của người khác là một âm thâm êm đềm, thân thương và quan trọng nhất đối với họ.
                Nguyên tắc 7: Biết lắng nghe và khuyến khích người khác nói về vấn đề của họ.
                Nguyên tắc 8: Nói về điều người khác quan tâm.
                Nguyên tắc 9: Thật lòng làm cho người khác cảm thấy họ quan trọng.',
            'author_id' => '1',
            'status' => 'published',
            'slug' => Str::slug('title'),
            'price' => '150000',
            'category_id' => '15',
            'publisher_id' => '1',
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Book::create([
            'title' => 'Thay Đổi Để Thành Công (Tái bản năm 2024)',
            'description' => 'Dù trong công việc hoặc trong cuộc sống cá nhân, nếu muốn tiến bộ, chúng ta cần sẵn lòng thay đổi cách thức làm việc hoặc thậm chí cách sinh hoạt. Điều này không có nghĩa là mọi thứ chúng ta làm đều cần phải thay đổi. Đúng ra là chúng ta nên cởi mở với những ý tưởng mới.

                    - Để có thể xác định cách thức tiến hành thay đổi trên con đường đi tới thành công, chúng ta sẽ xem xét sự thay đổi dưới nhiều khía cạnh khác nhau:

                    - Thay đổi như một bước tiến tới thành công

                    - Tự điều chỉnh để thay đổi

                    - Thời điểm và cách thức đề nghị hay bắt đầu sự thay đổi

                    - Cách thức tiến hành thay đổi với tư cách một thành viên của nhóm

                    - Giảm áp lực căng thẳng khi tiến hành thay đổi...',
            'author_id' => '1',
            'status' => 'published',
            'slug' => Str::slug('Thay Đổi Để Thành Công (Tái bản năm 2024)'),
            'price' => '143100',
            'category_id' => '15',
            'publisher_id' => '1',
            'published_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
