<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class deleteOrderRequest extends FormRequest
{
  public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'required|exists:orders,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'Đơn hàng cần xóa không được để trống.',
            'id.exists' => 'Đơn hàng cần không tồn tại trong hệ thống.',
        ];
    }
}
