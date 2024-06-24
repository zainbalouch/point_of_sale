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
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Product cagegories</a></li>
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
                <h6 class="card-title mb-0">Product Category Details</h6>
            </div>
            <div class="card-body">
                @include('layouts.partials._errors')
                <form action="{{ route('admin.product_categories.update', $productCategory->id) }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="full-name" class="form-label">Product category name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter product category name" name="name" value="{{ old('name', $productCategory->name) }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="parent-id" class="form-label">Product parent category</label>
                                <select class="form-select" id="parent-id" data-choices data-choices-search-true name="parent_id">
                                    <option value="">Select category</option>

                                    @foreach($productCategories as $category)
                                        @if($category->id != $productCategory->id)
                                            <option value="{{ $category->id }}" @if($category->id == $productCategory->parent_id) selected @endif>
                                                @if($category->parent_id === null)
                                                    {{ $category->name }}
                                                @else
                                                    @foreach($category->parentCategory->buildBreadcrumbs($category->parent_id) as $breadcrumb)
                                                        {{ $breadcrumb['name'] }} ->
                                                    @endforeach
                                                    {{ $category->name }}
                                                @endif
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
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
                        <!--end col-->
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
