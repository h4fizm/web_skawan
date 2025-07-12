<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductImages;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            try {
                $products = Products::with('productCategories.category', 'productImages')->get();
                return formatResponse('success', 'Data berhasil diambil!', $products, null, 200);
            } catch (\Exception $e) {
                return formatResponse('error', 'Gagal mengambil data produk!', null, $e->getMessage(), 500);
            }
        }
        return view('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_product' => 'required|string|max:255',
            'total_stock' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'information' => 'nullable|string',
            'categories' => 'required|array|min:1',
            'categories.*' => 'string|max:255', // Allow string category names
            'images' => 'nullable|array',
            'images.*' => 'file|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        DB::beginTransaction();

        try {
            // Create the product record
            $product = Products::create([
                'name_product' => $request->name_product,
                'total_stock' => $request->total_stock,
                'price' => $request->price,
                'description' => $request->description,
                'information' => $request->information,
            ]);

            // Handle categories (check if the category already exists or create new ones)
            $categories = [];

            foreach ($request->categories as $categoryName) {
                $category = Categories::firstOrCreate(['name_category' => $categoryName]);
                $categories[] = $category->id;
            }

            // Attach categories to the product
            if ($categories) {
                $product->productCategories()->attach($categories);
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('product_images', 'public');
                    ProductImages::create([
                        'id_product' => $product->id,
                        'image_path' => $path
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Produk berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
