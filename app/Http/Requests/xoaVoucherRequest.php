<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class xoaVoucherRequest extends FormRequest
{
   public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'id' => 'required|exists:vouchers,id',

        ];
    }
    public function messages()
    {
        return [
            'id.required' => 'Voucher cần xóa không được để trống.',
            'id.exists' => 'Voucher cần xóa không tồn tại.',
        ];
    }
}
