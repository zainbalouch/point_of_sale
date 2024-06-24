@extends('layouts.admin.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style type="text/css">
    #map {
        height: 600px;
    }

    .pin-icon .custom-icon {
        display: inline-block;
        color: #f13439;
        font-size: 40px;
    }
</style>
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Edit amenity category</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Amenity categories</a></li>
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
                <h6 class="card-title mb-0">Amenity category Details</h6>
            </div>
            <div class="card-body">
                @include('layouts.partials._errors')
                <form action="{{ route('admin.amenity_categories.update', $amenityCategory->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name', $amenityCategory->name) }}" required autocomplete="name" autofocus>
                                @error('name')
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
                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>


@endsection

@section('javascript')

@endsection