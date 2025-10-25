<?php

namespace App\Http\Controllers;

use App\Http\Requests\CapNhatProductsRequest;
use App\Http\Requests\deleteProductsRequest;
use App\Http\Requests\themProductsRequest;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function getData()
    {
        // Lấy sản phẩm + số lượng bán từ order_items
        $data = Products::with('reviews.user')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.*',
                DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold_quantity')
            )
            ->groupBy(
                'products.id',
                'products.title',
                'products.slug',      // thêm các cột còn thiếu
                'products.images',
                'products.quantity',
                'products.brand',
                'products.specs',
                'products.warranty',
                'products.status',
                'products.price',
                'products.description',
                'products.created_at',
                'products.updated_at'
            )
            ->get();

        // Tính trung bình rating & số lượt đánh giá
        $data->transform(function ($product) {
            $ratings = $product->reviews->pluck('rating');
            $product->avgRating = $ratings->count() ? round($ratings->avg(), 1) : 0;
            $product->reviewCount = $ratings->count();
            $product->sold_quantity = $product->sold_quantity ?? 0;
            return $product;
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getDataAdmin()
    {
        $data = Products::with('reviews.user')->get();

        $data->transform(function ($product) {
            $ratings = $product->reviews->pluck('rating');
            $product->avgRating = $ratings->count() ? round($ratings->avg(), 1) : 0;
            $product->reviewCount = $ratings->count();
            return $product;
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function update(CapNhatProductsRequest $request)
    {
        $product = Products::find($request->id);
        $product->update([
            'images'   => $request->images,
            'title'    => $request->title,
            'slug'     => $request->slug,
            'price'    => $request->price,
            'quantity' => $request->quantity,
            'brand' => $request->brand,
            'description' => $request->description,
            'specs' => $request->specs,
            'warranty' => $request->warranty,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã cập nhật sản phẩm " . $request->title . " thành công.",
        ]);
    }

    public function delete(deleteProductsRequest $request)
    {
        Products::find($request->id)->delete();
        return response()->json([
            'status' => true,
            'message' => "Đã xóa sản phẩm thành công.",
        ]);
    }
    public function create(themProductsRequest $request)
    {
        Products::create([
            'images'   => $request->images,
            'title'    => $request->title,
            'slug'     => $request->slug,
            'price'    => $request->price,
            'quantity' => $request->quantity,
            'brand' => $request->brand,
            'description' => $request->description,
            'specs' => $request->specs,
            'warranty' => $request->warranty,
            'status' => $request->status,
        ]);
        return response()->json([
            'status' => true,
            'message' => "Đã thêm sản phẩm thành công."
        ]);
    }
   public function show($id)
{
    // Lấy sản phẩm
    $product = Products::with('reviews.user')
        ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        ->select(
            'products.*',
            DB::raw('COALESCE(SUM(order_items.quantity), 0) as sold_quantity')
        )
        ->where('products.id', $id)
        ->groupBy(
            'products.id',
            'products.title',
            'products.slug',
            'products.images',
            'products.quantity',
            'products.brand',
            'products.specs',
            'products.warranty',
            'products.status',
            'products.price',
            'products.description',
            'products.created_at',
            'products.updated_at'
        )
        ->first();

    if (!$product) {
        return response()->json([
            'status'  => false,
            'message' => 'Không tìm thấy sản phẩm.'
        ], 404);
    }

    $ratings = $product->reviews->pluck('rating');
    $product->avgRating = $ratings->count() ? round($ratings->avg(), 1) : 0;
    $product->reviewCount = $ratings->count();
    $product->sold_quantity = $product->sold_quantity ?? 0;

    return response()->json([
        'status' => true,
        'data'   => $product
    ]);
}
    public function addReview(Request $request, $id)
    {
        $user = Auth::guard('sanctum')->user(); // <- sửa ở đây
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bạn cần đăng nhập để đánh giá sản phẩm.'
            ], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = new Review();
        $review->product_id = $id;
        $review->user_id = $user->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();

        return response()->json([
            'status' => 'success',
            'data' => $review
        ]);
    }

    public function getReviews($id)
    {
        $reviews = Review::with('user:id,name')
            ->where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $reviews
        ]);
    }
}
