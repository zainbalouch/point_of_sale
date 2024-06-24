@extends('layouts.admin.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style type="text/css">
    #map { height: 600px; }

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
            <h4 class="mb-sm-0">Edit property</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Properties</a></li>
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
                <h6 class="card-title mb-0">Property Details</h6>
            </div>
            <div class="card-body">
                @include('layouts.partials._errors')
                <form action="{{ route('admin.properties.update', $property->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter name" name="name" value="{{ old('name', $property->name) }}" required autocomplete="name" autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Type<span class="text-danger">*</span></label>
                                        <select class="form-select @error('property_type_id') is-invalid @enderror" id="type" name="property_type_id" data-choices data-choices-search-true>
                                            <option value="">Select property type</option>
                                            @foreach($propertyTypes as $propertyType)
                                            <option value="{{ $propertyType->id }}" {{ old('property_type_id', $property->property_type_id) == $propertyType->id ? 'selected' : '' }}>
                                                {{ $propertyType->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('property_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Opportunity description<span class="text-danger">*</span></label>
                                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="Enter opportunity description" name="description" required autocomplete="description" autofocus>{{ old('description', $property->description) }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="space-sqm" class="form-label">Space (SQM) <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('space_sqm') is-invalid @enderror" id="space-sqm" placeholder="Enter space (SQM)" name="space_sqm" value="{{ old('space_sqm', $property->space_sqm) }}" required autocomplete="space_sqm" autofocus>
                                        @error('space_sqm')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="number-of-rooms" class="form-label">Number of rooms <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('number_of_rooms') is-invalid @enderror" id="number-of-rooms" placeholder="Enter number of rooms" name="number_of_rooms" value="{{ old('number_of_rooms', $property->number_of_rooms) }}" required autocomplete="number_of_rooms" autofocus>
                                        @error('number_of_rooms')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="price-per-night" class="form-label">Price per night <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('price_per_night') is-invalid @enderror" id="price-per-night" placeholder="Enter price per night" name="price_per_night" value="{{ old('price_per_night', $property->price_per_night) }}" required autocomplete="price_per_night" autofocus>
                                        @error('price_per_night')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="city-id" class="form-label">City <span class="text-danger">*</span></label>
                                        <select class="form-select @error('city_id') is-invalid @enderror" id="city-id" name="city_id" value="{{ old('city_id', $property->city_id) }}">
                                            <option value="">Select city</option>
                                        </select>
                                        @error('city_id')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="max-guests" class="form-label">Max number of guests <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('max_guests') is-invalid @enderror" id="max-guests" placeholder="Enter maximum number of guests" name="max_guests" value="{{ old('max_guests', $property->max_guests) }}" required autocomplete="max_guests" autofocus>
                                        @error('max_guests')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="street" class="form-label">Street</label>
                                        <input type="text" class="form-control @error('street') is-invalid @enderror" id="street" placeholder="Enter street name" name="street" value="{{ old('street', $property->street) }}" autocomplete="street" autofocus>
                                        @error('street')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="full-address" class="form-label">Full address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('full_address') is-invalid @enderror" id="full-address" placeholder="Enter full address" name="full_address" value="{{ old('full_address', $property->full_address) }}" required autocomplete="full_address" autofocus>
                                        @error('full_address')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="latitude" class="form-label">Latitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('latitude') is-invalid @enderror" id="latitude" placeholder="Enter property latitude" name="latitude" value="{{ old('latitude', $property->latitude) }}" required autocomplete="latitude" autofocus>
                                        @error('latitude')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="longitude" class="form-label">Longitude <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('longitude') is-invalid @enderror" id="longitude" placeholder="Enter property longitude" name="longitude" value="{{ old('longitude', $property->longitude) }}" required autocomplete="latitude" autofocus>
                                        @error('longitude')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="postal-code" class="form-label">Postal code</label>
                                        <input type="text" class="form-control @error('postal-code') is-invalid @enderror" id="postal-code" placeholder="Enter property postal code" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" autocomplete="postal_code" autofocus>
                                        @error('postal_code')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="is-listed" class="form-label">List property</label>
                                        <select class="form-select @error('is_listed') is-invalid @enderror" id="is-listed" name="is_listed" data-choices data-choices-search-false>
                                            <option value="1" {{ old('is_listed', $property->is_listed) == 1 ? 'selected' : '' }}>Yes</option>
                                            <option value="0" {{ old('is_listed', $property->is_listed) == 0 ? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!--end row-->
                        </div>
                        <div class="col-lg-6">
                            <label class="form-label">Property location</label>
                            <div class="mb-3">
                                <div id="map"></div>
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
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-control-geocoder@1.13.0/dist/Control.Geocoder.js"></script>

<script type="text/javascript">
    var propertyCoordinates = [{{ $property->latitude }}, {{ $property->longitude }}];
    var map, marker, currentLocation;

    function initMap() {
        map = L.map('map').setView(propertyCoordinates, {{ $mapZoom }});

        L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            maxZoom: {{ $mapZoom }},
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        var locationIcon = L.divIcon({
            className: 'pin-icon',
            html: '<span class="custom-icon"><i class="bi bi-pin-fill"></i></span>',
            iconSize: [30, 30], // Adjust icon size if needed
            iconAnchor: [15, 30] // Adjust icon anchor if needed
        });

        marker = L.marker(propertyCoordinates, { draggable: true, icon: locationIcon })
            .bindPopup("Property location")
            .addTo(map)
            .on('dragend', updatePosition);

        document.getElementsByName('latitude')[0].value = propertyCoordinates[0];
        document.getElementsByName('longitude')[0].value = propertyCoordinates[1];
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
        }, { language: 'en' });
    }

    document.addEventListener('DOMContentLoaded', function () {
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
                        return { value: city.id, label: city.text };
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