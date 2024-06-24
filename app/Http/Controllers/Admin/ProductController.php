<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::all();

        return view('admin.products.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::with('childCategories')->get();

        return view('admin.products.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
           'description' => 'required',
           'code' => 'required',
           'price' => 'required',
           'product_category_id' => 'required|exists:product_categories,id'
        ]);

        Product::create($request->all());

        session()->flash('success', 'Created successfully');

        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        if($product) {
            $productCategories = ProductCategory::all();

            return view('admin.products.edit', compact('product', 'productCategories'));
        }
        
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'name' => 'required',
           'description' => 'required',
           'code' => 'required|unique:products',
           'price' => 'required',
           'product_category_id' => 'required|exists:product_categories,id'
        ]);

        $product = Product::find($id);

        if(!$product) {
            session()->flash('error', 'Product not found');

            return redirect()->back();
        }

        $product->update($request->all());

        session()->flash('success', 'Updated successfully');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if($product) {
            $product->delete();

            session()->flash('success', 'Deleted successfully');

            return redirect()->route('admin.products.index');
        }

        return redirect()->back();
    }

    public function data(Request $request)
    {
        $products = Product::with('category.parentCategory', 'category.childCategories')->orderBy('created_at', 'desc');

        return DataTables::of($products)
            ->editColumn('created_at', function (Product $product) {
                return $product->created_at->format('Y-m-d');
            })
            ->addColumn('breadcrumbs', function (Product $product) {
                $breadcrumbs = [$product->category->name];

                $currentCategory = $product->category;
                while ($currentCategory->parentCategory) {
                    $currentCategory = $currentCategory->parentCategory;
                    array_unshift($breadcrumbs, $currentCategory->name);
                }

                return $breadcrumbs;
            })
            ->addColumn('actions', 'admin.products.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }
}
