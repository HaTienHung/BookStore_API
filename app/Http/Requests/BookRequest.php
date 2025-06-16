<?php

namespace App\Http\Requests;

use App\Enums\RoleType;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $action = $this->segments()[3];

        switch ($action):
            case "store":
                $rule = [
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'status' => 'required|in:draft,published,archived',
                    'author_id' => 'required|integer|exists:authors,id',
                    'category_id' => 'required|integer|exists:categories,id',
                    'price' => 'required|numeric|min:0',
                    'published_at' => 'nullable|date_format:Y-m-d',
                ];
                if ($this->user()->role->name === RoleType::ADMIN->value) {
                    $rule['publisher_id'] = 'required|exists:publishers,id';
                } else {
                    $rule['publisher_id'] = 'prohibited';
                }
                break;
            case "update":
                $rule = [
                    'title' => 'nullable|string|max:255',
                    'description' => 'nullable|string',
                    'status' => 'nullable|in:draft,published,archived',
                    'author_id' => 'nullable|integer|exists:authors,id',
                    'category_id' => 'nullable|integer|exists:categories,id',
                    'price' => 'nullable|numeric|min:0',
                    'published_at' => 'nullable|date_format:Y-m-d',
                ];
                if ($this->user()->role->name === RoleType::ADMIN->value) {
                    $rule['publisher_id'] = 'nullable|exists:publishers,id';
                } else {
                    $rule['publisher_id'] = 'prohibited';
                }
                break;
            case "soft-delete":
                $rule = [
                    'ids' => 'required|array',
                    'ids.*' => 'required|integer|exists:books,id',
                ];
                break;
            case "recovery":
                $rule = [
                    'ids' => 'required|array',
                    'ids.*' => 'required|integer|exists:books,id',
                ];
                break;
            default:
                $rule = [];
        endswitch;

        return $rule;
    }

    public function messages(): array
    {
        return [
            //Id
            'ids.required'      => 'Vui lòng cung cấp danh sách ID| The ids field is required.',
            'ids.array'         => 'Danh sách ID không hợp lệ.| The ids must be an array.',
            'ids.*.required'    => 'ID không được để trống |  Each id is required.',
            'ids.*.integer'     => 'ID phải là số nguyên.| Each id must be an integer.',
            'ids.*.exists'      => 'ID không tồn tại trong hệ thống| Each id must exist in books table.',
            // Title
            'title.required' => 'Tiêu đề không được bỏ trống | Title is required.',
            'title.string' => 'Tiêu đề phải là chuỗi | Title must be a string.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự | Title may not be greater than 255 characters.',

            // Description
            'description.string' => 'Mô tả phải là chuỗi | Description must be a string.',

            // Status
            'status.required' => 'Trạng thái không được bỏ trống | Status is required.',
            'status.in' => 'Trạng thái chỉ có thể là draft hoặc published | Status must be draft or published.',

            // Author ID
            'author_id.required' => 'Tác giả không được bỏ trống | Author is required.',
            'author_id.integer' => 'Tác giả phải là số nguyên | Author must be an integer.',
            'author_id.exists' => 'Tác giả không tồn tại | Author does not exist.',

            // Category ID
            'category_id.required' => 'Danh mục không được bỏ trống | Category is required.',
            'category_id.integer' => 'Danh mục phải là số nguyên | Category must be an integer.',
            'category_id.exists' => 'Danh mục không tồn tại | Category does not exist.',

            // Publisher ID
            'publisher_id.required' => 'Nhà xuất bản không được bỏ trống | Publisher is required.',
            'publisher_id.integer' => 'Nhà xuất bản phải là số nguyên | Publisher must be an integer.',
            'publisher_id.exists' => 'Nhà xuất bản không tồn tại | Publisher does not exist.',

            // Price
            'price.required' => 'Giá sách không được bỏ trống | Price is required.',
            'price.numeric' => 'Giá sách phải là số | Price must be a number.',
            'price.min' => 'Giá sách phải lớn hơn hoặc bằng 0 | Price must be at least 0.',

            // Published at
            'published_at.date_format' => 'Ngày xuất bản phải có định dạng Y-m-d | Published date must be in Y-m-d format.',
        ];
    }
}
