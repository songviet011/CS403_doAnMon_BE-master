<?php

use App\Http\Controllers\AdminAccountController;
use App\Http\Controllers\ChatBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\SePayWebhookController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\VoucherControllerr;
use App\Listeners\SePayWebhookListener;
use App\Models\AdminAccount;
use App\Models\DanhMuc;
use App\Models\Voucher;
use Illuminate\Support\Facades\Log;
use SePay\SePay\Facades\SePay;
use SePay\SePay\Http\Controllers\SePayController;

// Customer

Route::get('/customer/data', [CustomerController::class, 'getData']);
Route::post('/customer/dang-nhap', [CustomerController::class, 'Login']);
Route::get('/customer/profile', [CustomerController::class, 'getProfile']);
Route::get('/users/check-token', [CustomerController::class, 'checkToken']);
Route::post('/customer/create', [CustomerController::class, 'create']);
Route::post('/customer/logout', [CustomerController::class, 'logout']);
Route::get('/customer/products/data', [CustomerController::class, 'getDataSanPham']);
Route::get('/customer/order/data', [CustomerController::class, 'getDataOrders']);
Route::get('/admin/user-account/data', [AdminAccountController::class, 'getDataCustomer']);
Route::post('/admin/user-account/create', [AdminAccountController::class, 'createCustomer']);
Route::post('/admin/user-account/delete', [AdminAccountController::class, 'deleteCustomer']);
Route::post('/admin/user-account/update', [AdminAccountController::class, 'updateCustomer']);
Route::get('/admin/statistical/customers', [CustomerController::class, 'statistical']);
Route::post('/customer/profile/update-profile', [CustomerController::class, 'updateProfile']);
Route::post('/customer/profile/update-password', [CustomerController::class, 'updatePassword']);

//Products
Route::get('/customer/products/data', [ProductsController::class, 'getData']);
Route::get('/admin/products/data', [ProductsController::class, 'getDataAdmin']);
Route::post('/admin/products/update', [ProductsController::class, 'update']);
Route::post('/admin/products/delete', [ProductsController::class, 'delete']);
Route::post('/admin/products/create', [ProductsController::class, 'create']);
Route::get('/admin/products/{id}', [ProductsController::class, 'show']);




//Admin Account
Route::post('/admin/dang-nhap', [AdminAccountController::class, 'Login']);
Route::get('/admin/check-token', [AdminAccountController::class, 'checkToken']);
Route::post('/admin/logout', [AdminAccountController::class, 'logout']);
Route::post('/admin/account/update', [AdminAccountController::class, 'update']);
Route::post('/admin/account/delete', [AdminAccountController::class, 'delete']);
Route::get('/admin/account/data', [AdminAccountController::class, 'getData']);
Route::post('/admin/account/create', [AdminAccountController::class, 'create']);

//Orders
Route::get('/admin/order/data', [OrdersController::class, 'getData']);
Route::post('/admin/order/update', [OrdersController::class, 'update']);
Route::post('/admin/order/delete', [OrdersController::class, 'delete']);
Route::get('/admin/order/{id}', [OrdersController::class, 'show']);
Route::get('/khach-hang/order/data', [OrdersController::class, 'getDonHangKhachHang']);
Route::post('/khach-hang/order/them-don-hang', [OrdersController::class, 'store']);
Route::get('/customer/order/new-code', [OrdersController::class, 'getNewOrderCode']);
Route::post('/customer/order/data-chi-tiet', [OrdersController::class, 'getChiTietDonHangKhachHang'])->middleware('customerMiddle');

//DanshBoard
Route::get('/admin/dashboard/thong-ke-doanh-thu', [DashboardController::class, 'thongkeDoanhThu']);
Route::get('/admin/dashboard/data', [DashboardController::class, 'getData']);

//Voucher
Route::get('/admin/voucher/data', [VoucherControllerr::class, 'getData'])->middleware('adminMiddle');
Route::get('/customer/voucher/data', [CustomerController::class, 'getDataVoucher'])->middleware('customerMiddle');
Route::post('/admin/voucher/create', [VoucherControllerr::class, 'createVoucher'])->middleware('adminMiddle');
Route::post('/admin/voucher/update', [VoucherControllerr::class, 'updateVoucher'])->middleware('adminMiddle');
Route::post('/admin/voucher/delete', [VoucherControllerr::class, 'deleteVoucher'])->middleware('adminMiddle');

//DanhMuc
Route::get('/customer/danh-muc/data',[DanhMucController::class, 'getData']);

//GioHang
Route::get('/customer/gio-hang/data',[GioHangController::class, 'getCart']);
Route::post('/customer/gio-hang/add',[GioHangController::class, 'addToCart'])->middleware('customerMiddle');
Route::post('/customer/gio-hang/delete/{id}',[GioHangController::class, 'removeFromCart'])->middleware('customerMiddle');
Route::post('/customer/gio-hang/checkout',[GioHangController::class, 'checkout'])->middleware('customerMiddle');
Route::post('/customer/gio-hang/update-quantity/{id}',[GioHangController::class, 'updateQuantity'])->middleware('customerMiddle');

//Thanh Toán
Route::post('/hooks/sepay-payment', [SePayWebhookController::class, 'handle']);
Route::post('/hooks/sepay-payment/check-status', [SePayWebhookController::class, 'checkStatus']);


//Chatbot
Route::post('customer/chat', [ChatBotController::class, 'chat']);

//Đánh Giá
Route::post('/customer/products/{id}/review', [ProductsController::class, 'addReview'])->middleware('customerMiddle');
Route::get('/customer/products/{id}/reviews', [ProductsController::class, 'getReviews']);


//Train Chatbot
use App\Http\Controllers\TrainChatController;

Route::post('/admin/chat/train-all',      [TrainChatController::class, 'trainAll']);
Route::post('/admin/chat/train-products', [TrainChatController::class, 'trainProducts']);
Route::post('/admin/chat/train-vouchers', [TrainChatController::class, 'trainVouchers']);
Route::post('/admin/chat/train-static',   [TrainChatController::class, 'trainStatic']);


