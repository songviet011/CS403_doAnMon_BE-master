<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminDangNhapRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
<<<<<<< HEAD
    {
        return [
            'email' => 'required|exists:admin_accounts,email',
            'password' => 'required|max:10|min:4'
        ];
    }
=======
{
    return [
        'email' => 'required|email',
        'password' => 'required|min:4|max:10',
    ];
}

>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
}
