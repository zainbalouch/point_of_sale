@extends('layouts.admin.app')

@section('styles')

@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Edit product</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">Product Details</h6>
            </div>
            <div class="card-body">
                @include('layouts.partials._errors')
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name', $product->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="Enter product code" name="code" value="{{ old('code', $product->code) }}" required autocomplete="code" autofocus>
                                @error('code')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="description" class="form-label">Description<span class="text-danger">*</span></label>
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Enter product description" name="description" required autocomplete="description" autofocus>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="Property-type-input" class="form-label">Category<span class="text-danger">*</span></label>

                                <select class="form-select" id="Property-type-input" data-choices data-choices-search-true name="product_category_id">
                                    <option value="">Select category</option>
                                    @forelse($productCategories as $productCategory)
                                        <option value="{{ $productCategory->id }}" @if($product->product_category_id == $productCategory->id) selected @endif>{{ $productCategory->name }}</option>
                                    @empty
                                        <option value="">There are no categories to show</option>
                                    @endforelse
                                </select>
                                @error('product_category_id')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="Enter product price" name="price" value="{{ old('price', $product->price) }}" required autocomplete="price" autofocus>
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                    <!--end row-->
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>


@endsection

@section('javascript')

@endsection
