@extends('layouts.admin.app')

@section('content')
<!-- Container-fluid start -->
<div class="container-fluid">
    <div class="page-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="page-header-left">
                    <h3>@lang('site.manage_users')</h3>
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
                    <li class="breadcrumb-item">@lang('site.manage_users')</li>
                </ol>
                <!-- Breadcrumb end -->
                
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid end -->

<!-- Container-fluid start -->

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                <div class="row review-form gx-3">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="@lang('site.keyword')">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <button type="submit" class="btn btn-primary btn-sm">@lang('site.search')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Container-fluid end -->

<!-- Container-fluid start -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">
                        <h5>@lang('site.users')</h5>
                        <a href="{{ route('admin.users.create') }}">@lang('site.create')</a>
                    </div>
                </div>
                <div class="card-body assign-table pt-0">
                    <div class="table-responsive">
                        <table class="table table-striped">
                        	<thead>
                        		<tr>
                        			<th class="light-font">#</th>
                        			<th class="light-font">@lang('site.avatar')</th>
                        			<th class="light-font">@lang('site.first_name')</th>
                        			<th class="light-font">@lang('site.last_name')</th>
                        			<th class="light-font">@lang('site.email')</th>
                        			<th class="light-font">@lang('site.created_at')</th>
                                    <th class="light-font">@lang('site.options')</th>
                        		</tr>
                        	</thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                	<td>
                                        <h6>10</h6>
                                    </td>
                                    <td>
                                        <div class="media">
                                            <img src="{{ asset('assets/images/avatar/1.jpg') }}" class="img-fluid" alt="">
                                        </div>
                                    </td>
                                    <td>
                                        <h6>{{ $user->first_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $user->last_name }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $user->email }}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $user->created_at }}</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary me-2 btn-sm">
                                                <h6>@lang('site.edit')</h6>
                                            </a>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                @csrf
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger btn-sm">@lang('site.delete')</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <p class="my-2">@lang('site.no_data_found')</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid end -->
@endsection
