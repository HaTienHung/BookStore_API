<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories');

        $categories = [
            [
                'name' => 'Văn học',
                'children' => [
                    'Tiểu thuyết',
                    'Truyện ngắn',
                    'Thơ ca',
                    'Văn học nước ngoài',
                    'Tản văn',
                ],
            ],
            [
                'name' => 'Kinh tế / Kinh doanh',
                'children' => [
                    'Khởi nghiệp',
                    'Tài chính cá nhân',
                    'Quản trị doanh nghiệp',
                    'Marketing',
                    'Đầu tư chứng khoán',
                ],
            ],
            [
                'name' => 'Kỹ năng / Sống đẹp',
                'children' => [
                    'Phát triển bản thân',
                    'Kỹ năng giao tiếp',
                    'Quản lý thời gian',
                    'Tư duy tích cực',
                    'Sống tối giản',
                ],
            ],
            [
                'name' => 'Truyện tranh / Manga',
                'children' => [
                    'Manga Nhật Bản',
                    'Comic phương Tây',
                    'Truyện thiếu nhi',
                    'Light Novel',
                    'Truyện tranh Việt',
                ],
            ],
            [
                'name' => 'Kiến trúc, hội họa, điện ảnh',
                'children' => [
                    'Lịch sử kiến trúc',
                    'Thiết kế nội thất',
                    'Hội họa hiện đại',
                    'Điện ảnh thế giới',
                    'Nhiếp ảnh nghệ thuật',
                ],
            ],
        ];

        foreach ($categories as $category) {
            $parentId = DB::table('categories')->insertGetId([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'parent_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            foreach ($category['children'] as $childName) {
                DB::table('categories')->insert([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parentId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
