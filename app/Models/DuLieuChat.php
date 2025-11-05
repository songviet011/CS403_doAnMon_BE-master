<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DuLieuChat extends Model
{
    protected $table = 'du_lieu_chats';
    protected $fillable = ['content', 'embedding', 'hash'];
}
