<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class xoaCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => 'required|exists:customers,id',
        ];
    }
    public function messages(): array
    {
        return [
            'id.required' => 'Tài khoản cần xóa không được để trống.',
            'id.exists' => 'Tài khoản cần không tồn tại trong hệ thống.',
        ];
    }
}
