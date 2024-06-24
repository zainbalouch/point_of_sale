@extends('layouts.admin.app')

@section('content')
<!-- Container-fluid start -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-header-left">
                    <h3>@lang('site.create')</h3>
                </div>
            </div>
            <div class="col-sm-6">

                <!-- Breadcrumb start -->
                <ol class="breadcrumb pull-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard.index') }}">
                            <i class="fa fa-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.users.index') }}">@lang('site.manage_users')</a>
                    </li>
                    <li class="breadcrumb-item">@lang('site.create')</li>
                </ol>
                <!-- Breadcrumb end -->
                
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid end -->

<!-- Container-fluid start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card"> 
                <div class="card-header pb-0">
                    <h5>Add user details</h5>
                </div>
                 <div class="card-body admin-form">
                    <form class="row gx-3">
                        <div class="form-group col-md-4 col-sm-6">
                            <label>@lang('site.first_name') <span class="font-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" placeholder="@lang('site.first_name')" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>@lang('site.last_name') <span class="font-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" placeholder="@lang('site.last_name')" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>Gender <span class="font-danger">*</span></label>
                            <div class="dropdown">
                                <span class="dropdown-toggle font-rubik" data-bs-toggle="dropdown"><span>Gender</span> <i class="fas fa-angle-down"></i></span>
                                <div class="dropdown-menu text-start">
                                    <a class="dropdown-item" href="javascript:void(0)">Male</a>
                                    <a class="dropdown-item" href="javascript:void(0)">Female</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>@lang('site.email') <span class="font-danger">*</span></label>
                            <input type="text" class="form-control" name="email" placeholder="@lang('site.email')" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>Date of birth <span class="font-danger">*</span></label>
                            <input class="form-control" placeholder="18 april" id="datepicker" />
                        </div>
                        <div class="form-group col-md-4 col-sm-6">
                            <label>Email Address <span class="font-danger">*</span></label>
                            <input type="email" class="form-control" placeholder="enter your email" required="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Password <span class="font-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter your password">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Confirm Password <span class="font-danger">*</span></label>
                            <input type="password" class="form-control" placeholder="Enter your password">
                        </div>
                        <div class="form-group col-sm-12">
                            <label>Description</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Address</label>
                            <input type="text" class="form-control" placeholder="Enter your Address">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Zip code</label>
                            <input type="number" class="form-control" placeholder="Enter pin code">
                        </div>
                    </form>
                    <div class="form-btn">
                        <button type="button" class="btn btn-pill btn-gradient color-4">Submit</button>
                        <button type="button" class="btn btn-pill btn-dashed color-4">Cancel</button>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid end -->
@endsection

@section('scripts')

@endsestion
