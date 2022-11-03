<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response([
            'status' => true,
            'products' => Product::paginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $product = Product::create($request->only('title', 'description', 'image', 'price'));

        return response([
            'status' => true,
            'product' => $product,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return Response
     */
    public function show(Product $product): Response
    {
        return response([
            'status' => true,
            'product' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product): Response
    {
        $product->update($request->only('title', 'description', 'image', 'price'));

        return response([
            'status' => true,
            'product' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return Response
     */
    public function destroy(Product $product): Response
    {
        $product->delete();

        return response([
            'status' => true,
            'message' => 'Product deleted',
        ], Response::HTTP_NO_CONTENT);
    }

    public function frontend(): Collection
    {
        if ($products = Cache::get('products_frontend')) {
            return $products;
        }

        $products = Product::all();

        Cache::set('products_frontend', $products, 30 * 60);

        return $products;
    }

    public function backend(): LengthAwarePaginator
    {
        return Cache::remember('products_backend', 30 * 60, function () {
            return Product::paginate();
        });
    }
}
