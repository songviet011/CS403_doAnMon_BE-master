<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class capNhatCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'required|exists:admin_accounts,id',
            'ho_va_ten' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'so_dien_thoai' => 'required|digits_between:10,12',
            'dia_chi' => 'required|string',
            'ngay_sinh' => 'required|date',

        ];
    }
    public function messages(): array
    {
        return [
            // ID
            'id.required'       => 'ID tài khoản không được để trống',
            'id.exists'         => 'Tài khoản không tồn tại trong hệ thống',

            // Họ và tên
            'ho_va_ten.required' => 'Họ và tên là bắt buộc',
            'ho_va_ten.string'   => 'Họ và tên phải là chuỗi ký tự',
            'ho_va_ten.max'      => 'Họ và tên không được vượt quá 255 ký tự',

            // Email
            'email.required' => 'Email là bắt buộc',
            'email.email'    => 'Email không đúng định dạng',
            'email.max'      => 'Email không được vượt quá 255 ký tự',

            // Password
            'password.required' => 'Mật khẩu là bắt buộc',
            'password.string'   => 'Mật khẩu phải là chuỗi ký tự',
            'password.min'      => 'Mật khẩu phải có ít nhất 6 ký tự',

            // Số điện thoại
            'so_dien_thoai.required'       => 'Số điện thoại là bắt buộc',
            'so_dien_thoai.digits_between' => 'Số điện thoại phải từ 10 đến 12 chữ số',
            'so_dien_thoai.numeric'        => 'Số điện thoại chỉ được chứa số',

            // Địa chỉ
            'dia_chi.required' => 'Địa chỉ là bắt buộc',
            'dia_chi.string'   => 'Địa chỉ phải là chuỗi ký tự',
            'dia_chi.max'      => 'Địa chỉ không được vượt quá 255 ký tự',

            // Ngày sinh
            'ngay_sinh.required' => 'Ngày sinh là bắt buộc',
            'ngay_sinh.date'     => 'Ngày sinh không đúng định dạng (YYYY-MM-DD)',
        ];
    }
}
