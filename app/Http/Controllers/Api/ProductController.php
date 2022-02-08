<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $target_db = $request->target_db ? $request->target_db : 'filters';
        $target_table = $request->target_table ? $request->target_table : 'shop';

        $search_key = $request->search_key ? $request->search_key : '';
        $category = $request->category ? $request->category : '';
        $manufacturer = $request->manufacturer ? $request->manufacturer : '';
        $date_added = $request->date_added ? $request->date_added : '';
        $date_modified = $request->date_modified ? $request->date_modified : '';
        $sorting_type = $request->sorting_type ? $request->sorting_type : '0';
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 30;

        $target_table = 'kvp_' . $target_table . '_product';

        $products = DB::table($target_table)
                        ->where(function($query) use ($search_key) {
                            $query->where('id', $search_key)
                                ->orWhere('name', 'like', '%' . $search_key . '%')
                                ->orWhere('model', 'like', '%' . $search_key . '%');
                        })
                        ->where(function($query) use ($category, $manufacturer, $date_added, $date_modified) {
                            if ($category) $query->where('category', $category);
                            if ($manufacturer) $query->where('manufacturer', $manufacturer);
                            if ($date_added) $query->whereBetween('date_added', [$date_added . '00:00:00', $date_added . '23:59:59']);
                            if ($date_modified) $query->whereBetween('date_modified', [$date_modified . '00:00:00', $date_modified . '23:59:59']);
                        })
                        ->orderBy('date_modified', ($sorting_type == '1' ? 'desc' : 'asc'))
                        ->offset(($page - 1) * $limit)
                        ->limit($limit)
                        ->get();

        $total_counts = DB::table($target_table)
                            ->where(function($query) use ($search_key) {
                                $query->where('id', $search_key)
                                    ->orWhere('name', 'like', '%' . $search_key . '%')
                                    ->orWhere('model', 'like', '%' . $search_key . '%');
                            })
                            ->where(function($query) use ($category, $manufacturer, $date_added, $date_modified) {
                                if ($category) $query->where('category', $category);
                                if ($manufacturer) $query->where('manufacturer', $manufacturer);
                                if ($date_added) $query->whereBetween('date_added', [$date_added . '00:00:00', $date_added . '23:59:59']);
                                if ($date_modified) $query->whereBetween('date_modified', [$date_modified . '00:00:00', $date_modified . '23:59:59']);
                            })
                            ->count();

        return [
            'products' => $products,
            'page' => $page,
            'limit' => $limit,
            'total_pages' => ceil($total_counts / $limit),
            'total_counts' => $total_counts,
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $attributes = $request->validated();

        try {
            return Product::create($attributes);
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $attributes = $request->validated();

        try {
            $product = Product::find($id);

            $product->update($attributes);

            return $product;
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::find($id);

            $product->delete();

            return ['status' => true];
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }

    /**
     * Get Categories
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCategories(Request $request) {
        try {
            $categories = Product::distinct()->orderBy('category')->get(['category']);

            return $categories;
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }

    /**
     * Get Brands
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getBrands(Request $request) {
        try {
            $brands = Product::distinct()->orderBy('manufacturer')->get(['manufacturer']);

            return $brands;
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }


    /**
     * Update multiple products' status
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProductsStatus(Request $request) {
        $status = $request->status;
        $product_ids = $request->product_ids;

        $target_db = $request->target_db ? $request->target_db : 'filters';
        $target_table = $request->target_table ? $request->target_table : 'shop';

        $target_table = 'kvp_' . $target_table . '_product';

        try {
            DB::table($target_table)->whereIn('id', $product_ids)->update(['status' => $status]);

            return ['status' => true];
        } catch (\Throwable $t) {
            report($t);
            abort(500, $t->getMessage());
        }
    }
}
