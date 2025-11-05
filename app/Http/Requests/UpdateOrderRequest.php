<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép admin
    }

    public function rules(): array
    {
        return [
            'id'             => 'required|exists:orders,id',
            'ten_nguoi_nhan' => 'nullable|string|max:255',
            'so_dien_thoai'  => 'nullable|string|max:20',
            'tinh_trang' => 'required|integer',
            'is_thanh_toan'  => 'boolean',
            'tong_tien'      => 'nullable|numeric|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Thiếu ID đơn hàng cần cập nhật.',
            'id.exists'   => 'Đơn hàng không tồn tại.',
        ];
    }
}
