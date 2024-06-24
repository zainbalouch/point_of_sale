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
            <h4 class="mb-sm-0">Create amenity</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Amenities</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                <h6 class="card-title mb-0">Amenity Details</h6>
            </div>
            <div class="card-body">
                @include('layouts.partials._errors')
                <form action="{{ route('admin.amenities.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="amenity-category-id" class="form-label">Category<span class="text-danger">*</span></label>
                                <select class="form-select @error('amenity_category_id') is-invalid @enderror" id="amenity-category-id" name="amenity_category_id" data-choices data-choices-search-true>
                                    <option value="">Select category</option>
                                    @foreach($amenityCategories as $amenityCategory)
                                    <option value="{{ $amenityCategory->id }}" {{ old('amenity_category_id') == $amenityCategory->id ? 'selected' : '' }}>
                                        {{ $amenityCategory->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('amenity_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="submit" class="btn btn-primary">Create</button>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>

<script type="text/javascript">
    var map, marker, currentLocation;

    function initMap() {
        map = L.map('map').setView([24.6389160, 46.7160104], {
            {
                $mapZoom
            }
        });

        L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            maxZoom: 22,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, handleLocationError);
        }
    }

    function handleLocationError() {
        console.error("Error getting your location.");
    }

    function showPosition(position) {
        currentLocation = [position.coords.latitude, position.coords.longitude];

        document.getElementsByName('latitude')[0].value = currentLocation[0];
        document.getElementsByName('longitude')[0].value = currentLocation[1];

        if (marker) {
            map.removeLayer(marker);
        }

        var locationIcon = L.divIcon({
            className: 'pin-icon',
            html: '<span class="custom-icon"><i class="bi bi-pin-fill"></i></span>',
            iconSize: [30, 30], // Adjust icon size if needed
            iconAnchor: [15, 30] // Adjust icon anchor if needed
        });
        marker = L.marker(currentLocation, {
                draggable: true,
                icon: locationIcon
            })
            .bindPopup("Your current location")
            .addTo(map)
            .on('dragend', updatePosition);

        map.setView(currentLocation, {
            {
                $mapZoom
            }
        });
    }

    function updatePosition(event) {
        var newLatLng = event.target.getLatLng();
        document.getElementsByName('latitude')[0].value = newLatLng.lat;
        document.getElementsByName('longitude')[0].value = newLatLng.lng;

        // Reverse Geocode to get the address and postal code
        var geocoder = L.Control.Geocoder.nominatim();
        geocoder.reverse(newLatLng, map.options.crs.scale(map.getZoom()), function(results) {
            if (results && results[0]) {
                var address = results[0].name || '';
                document.getElementsByName('full_address')[0].value = address;
                document.getElementsByName('street')[0].value = results[0].properties.address.road || "";
                document.getElementsByName('postal_code')[0].value = results[0].properties.address.postcode || "";
            }
        }, {
            language: 'en'
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var config = {
            searchEnabled: true,
            searchResultLimit: 15,
            searchChoices: false,
            shouldSort: false,
            removeItemButton: true
        };
        var citySelect = document.getElementById('city-id');
        var choice = new window.Choices(citySelect, config);

        citySelect.addEventListener('search', function(event) {
            if (event.detail.value) {
                fetch(`{{ route('admin.locations.cities') }}?search=${event.detail.value}`)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        var newChoices = data.map(function(city) {
                            return {
                                value: city.id,
                                label: city.text
                            };
                        });
                        choice.clearChoices();
                        choice.setChoices(newChoices, 'value', 'label', true);
                    })
                    .catch(function(error) {
                        console.error('Error loading cities:', error);
                    });
            }
        });
    });
</script>



@endsection