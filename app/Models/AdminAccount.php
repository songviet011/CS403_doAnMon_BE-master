<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
=======

>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
class AdminAccount extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'admin_accounts';
<<<<<<< HEAD
=======

>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
    protected $fillable = [
        'email',
        'ho_va_ten',
        'password',
        'so_dien_thoai',
        'dia_chi',
        'ngay_sinh',
    ];
<<<<<<< HEAD
=======

    // Ẩn password khi trả JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tự động mã hóa password khi lưu
    // public function setPasswordAttribute($value)
    // {
    //     $this->attributes['password'] = bcrypt($value);
    // }
>>>>>>> 533f6d0ddad997d6e7f22d7b5dc3b8c89c757669
}
