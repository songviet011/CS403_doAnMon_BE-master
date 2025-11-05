<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class themProductsRequest extends FormRequest
{

    public function authorize()
    {
        return true; // Cho phép tất cả, có thể custom theo quyền
    }

    public function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|max:255|unique:products,slug',
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

    public function messages()
    {
        return [
            'title.required'    => 'Tên sản phẩm không được để trống.',
            'slug.required'     => 'Slug không được để trống.',
            'slug.unique'       => 'Slug này đã tồn tại, vui lòng chọn slug khác.',
            'price.required'    => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric'     => 'Giá sản phẩm phải là số.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer'  => 'Số lượng phải là số nguyên.',
            'brand.string'      => 'Thương hiệu phải là chuỗi ký tự.',
            'specs.json'        => 'Thông số kỹ thuật phải đúng định dạng JSON.',
            'warranty.integer'  => 'Bảo hành phải là số nguyên.',
            'status.required'   => 'Trạng thái không được để trống.',
            'status.in'         => 'Trạng thái chỉ được chọn: active, inactive hoặc out_of_stock.',
        ];
    }
}
