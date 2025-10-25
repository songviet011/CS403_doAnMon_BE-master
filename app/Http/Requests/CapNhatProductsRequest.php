<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CapNhatProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'          => 'required|exists:products,id',
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:products,slug,' . $this->id,
            'images'      => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'brand'       => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'specs'       => 'nullable|json',
            'warranty'    => 'nullable|integer|min:0',
            'status'      => 'required|in:active,inactive,out_of_stock',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required'       => 'Không tìm thấy sản phẩm cần cập nhật.',
            'id.exists'         => 'Sản phẩm không tồn tại trong hệ thống.',
            'title.required'    => 'Tên sản phẩm không được để trống.',
            'slug.required'     => 'Slug không được để trống.',
            'slug.unique'       => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
            'price.required'    => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric'     => 'Giá sản phẩm phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'status.required'   => 'Trạng thái không được để trống.',
            'status.in'         => 'Trạng thái chỉ được chọn: active, inactive hoặc out_of_stock.',
        ];
    }
}
