<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class themAdminRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'ho_va_ten'   => 'required|string|max:30',
            'email'    => 'required|string|max:255',
            'password'     => 'required|string|max:30',
            'so_dien_thoai'    => 'required|string|digits:10,12',
            'dia_chi' => 'required|string|max:255',
            'ngay_sinh'   => 'required|date'
        ];
    }
    public function messages()
    {
        return [
            'ho_va_ten.required' => 'Họ và tên không được để trống.',
            'ho_va_ten.string' => 'Họ và tên phải là một chuỗi ký tự.',
            'ho_va_ten.max' => 'Họ và tên không được vượt quá 30 ký tự.',

            'email.required' => 'Email không được để trống.',
            'email.string' => 'Email phải là một chuỗi ký tự.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 30 ký tự.',

            'so_dien_thoai.required' => 'Số điện thoại không được để trống.',
            'so_dien_thoai.string' => 'Số điện thoại phải là một chuỗi số.',
            'so_dien_thoai.digits' => 'Số điện thoại phải có đúng 10 đến 12 chữ số.',

            'dia_chi.required' => 'Địa chỉ không được để trống.',
            'dia_chi.string' => 'Địa chỉ phải là một chuỗi ký tự.',
            'dia_chi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'ngay_sinh.required' => 'Ngày sinh không được để trống.',
            'ngay_sinh.date' => 'Ngày sinh phải là một ngày hợp lệ.',
        ];
    }
}
