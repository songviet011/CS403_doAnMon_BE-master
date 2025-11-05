<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class deleteProductsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Vui lòng cung cấp ID sản phẩm cần xóa.',
            'id.exists'   => 'Sản phẩm không tồn tại trong hệ thống.',
        ];
    }
}
