<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function getData()
    {
        $data = DanhMuc::get();

        return response()->json([
            'data' => $data
        ]);
    }
}
