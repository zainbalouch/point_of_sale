@extends('layouts.admin.app')

@section('styles')
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- Sweet Alert css-->
<link href="{{ asset('static/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" >
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Reservations</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.reservations.index') }}">Reservations</a></li>
                    <li class="breadcrumb-item active">Listing</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-xl-12 col-sm-6">
                        <div class="search-box">
                            <input type="text" class="form-control search" placeholder="Search reservations">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>
                </div><!--end row-->
            </div><!--end card-body-->
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <div class="flex-grow-1">
                    <h5 class="card-title mb-0">Reservations</h5>
                </div>
                <div class="flex-shrink-0">
                    <div class="d-flex flex-wrap align-items-start gap-2">
                        <button class="btn btn-subtle-danger d-none" id="remove-actions" onClick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                        <a href="{{ route('admin.reservations.create') }}" type="button" class="btn btn-primary add-btn"><i class="bi bi-plus-circle align-baseline me-1"></i> Add reservation</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table datatable">
                    <table id="reservations-table" class="display table table-bordered table-nowrap table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Property</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Guest</th>
                                <th>Currency</th>
                                <th>Total Price</th>
                                <th>Cleaning fee</th>
                                <th>Service fee</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Created at</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>

@endsection

@section('javascript')
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Sweet Alerts js -->
<script src="{{ asset('static/libs/sweetalert2/sweetalert2.min.js') }}"></script>

<!-- Include DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script>
    $(document).ready(function() {
        let reservationsTable = $('#reservations-table').DataTable({
            dom: "tiplr",
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.reservations.data') }}",
            order: [
                [2, 'desc']
            ],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'property',
                    name: 'property'
                },
                {
                    data: 'user',
                    name: 'user'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'guest',
                    name: 'guest'
                },
                {
                    data: 'currency',
                    name: 'currency'
                },
                {
                    data: 'total_price',
                    name: 'total_price'
                },
                {
                    data: 'cleaning_fee',
                    name: 'cleaning_fee'
                },
                {
                    data: 'service_fee',
                    name: 'total_price'
                },
                {
                    data: 'check_in',
                    name: 'check_in'
                },
                {
                    data: 'check_out',
                    name: 'check_out'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    searchable: false,
                    sortable: false,
                    width: '20%'
                }
            ]
        });

        $('#data-table-search').keyup(function() {
            reservationsTable.search(this.value).draw();
        });

        // SweetAlert2 for delete buttons
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection