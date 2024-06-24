@extends('layouts.admin.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
<style type="text/css">
    #map { height: 800px; }
</style>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>


@endsection

@section('javascript')
<script src="{{ asset('static/libs/list.js/list.min.js') }}"></script>

<!-- echarts js -->
<script src="{{ asset('static/libs/echarts/echarts.min.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('static/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- list js-->
<script src="{{ asset('static/libs/list.js/list.min.js' )}}"></script>
<script src="{{ asset('static/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!--dashboard crm init js-->
<script src="{{ asset('static/js/pages/dashboard-crm.init.js') }}"></script>

@endsection
