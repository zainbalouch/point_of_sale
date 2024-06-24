@extends('layouts.admin.app')

@section('styles')

@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">General settings</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Settings</a></li>
                    <li class="breadcrumb-item active">General</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xxl-12">
        @include('layouts.admin.partials._errors')
        <form action="{{ route('admin.settings.store') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">Ticket settings</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="ticket-number-prefix" class="form-label">Ticket number prefix <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('ticket_number_prefix') is-invalid @enderror" id="ticket-number-prefix" placeholder="Enter ticket number prefix" name="ticket_number_prefix" value="{{ old('ticket_number_prefix', setting('ticket_number_prefix')) }}" required autocomplete="ticket_number_prefix" autofocus>
                                <small class="text-info">The ticket number prefix for example: (SB-)</small>
                                @error('ticket_number_prefix')
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
                </div>
            </div>
        </form>
    </div>
    <!--end col-->
</div>


@endsection

@section('javascript')

@endsection
