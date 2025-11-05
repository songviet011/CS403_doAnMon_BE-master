<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getData(Request $request)
{
    // Chỉ tính đơn hàng có tinh_trang = 1
    $totalOrders = Orders::where('tinh_trang', 1)->count();
    $totalRevenue = Orders::where('tinh_trang', 1)->sum('tong_tien');

    $totalCustomers = Customer::count();
    $bounceRate = rand(10, 40); // tạm random cho có số %

    // Thống kê theo ngày, chỉ tính đơn hàng tinh_trang = 1
    $sales = Orders::where('tinh_trang', 1)
        ->select(
            DB::raw('DATE(created_at) as ngay'),
            DB::raw('COUNT(id) as so_don'),
            DB::raw('SUM(tong_tien) as tong_tien')
        )
        ->groupBy('ngay')
        ->orderBy('ngay', 'asc')
        ->get();

    return response()->json([
        'status' => true,
        'data' => [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalCustomers' => $totalCustomers,
            'bounceRate' => $bounceRate,
            'sales' => $sales
        ]
    ]);
}
}
