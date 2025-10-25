<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherUser extends Model
{
    protected $table = 'voucher_users';
    protected $fillable = ['voucher_id', 'user_id', 'so_lan_da_dung'];

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'voucher_user')
            ->withPivot('so_lan_da_dung')
            ->withTimestamps();
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'voucher_user')
            ->withPivot('so_lan_da_dung')
            ->withTimestamps();
    }

    public function canUse()
    {
        return $this->so_lan_da_dung < 2;
    }
    public function incrementUsage()
    {
        $this->increment('so_lan_da_dung');
    }
}
