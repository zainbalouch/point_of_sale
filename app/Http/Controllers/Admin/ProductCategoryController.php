<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = ProductCategory::with('childCategories')->get();

        return view('admin.product_categories.index', compact('productCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = ProductCategory::with('childCategories')->get();

        return view('admin.product_categories.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
           'name' => 'required',
        ]);

        $industry = ProductCategory::create($request->all());

        session()->flash('success', 'Created successfully');

        return redirect()->route('admin.product_categories.index');
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
        $productCategory = ProductCategory::find($id);

        if($productCategory) {
            $productCategories = ProductCategory::with('childCategories')->get();

            return view('admin.product_categories.edit', compact('productCategory', 'productCategories'));
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
           'name' => 'required'
        ]);

        $productCategory = ProductCategory::find($id);

        if($productCategory) {
            $productCategory->update($request->all());

            session()->flash('success', 'Updated successfully');

            return redirect()->route('admin.product_categories.index');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $productCategory = ProductCategory::find($id);

        if($productCategory) {
            $productCategory->delete();

            session()->flash('success', 'Deleted successfully');

            return redirect()->route('admin.product_categories.index');
        }

        return redirect()->back();
    }

    public function data(Request $request)
    {
        $productCategories = ProductCategory::with('parentCategory', 'childCategories')->select();

        return DataTables::of($productCategories)
            ->editColumn('created_at', function (ProductCategory $productCategory) {
                return $productCategory->created_at->format('Y-m-d');
            })
            ->addColumn('breadcrumbs', function (ProductCategory $productCategory) {
                $breadcrumbs = [$productCategory->name];

                while ($productCategory->parentCategory) {
                    $productCategory = $productCategory->parentCategory;
                    array_unshift($breadcrumbs, $productCategory->name);
                }

                return $breadcrumbs;
            })
            ->addColumn('actions', 'admin.product_categories.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }
}