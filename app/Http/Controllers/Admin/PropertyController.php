<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\City;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.properties.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $propertyTypes = PropertyType::all();
        $cities = City::with('state.country')->get();
        $allowedDistance = setting('allowed_distance');
        $mapZoom = setting('map_zoom');

        return view('admin.properties.create', compact('propertyTypes', 'cities', 'allowedDistance', 'mapZoom'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'space_sqm' => 'required',
            'max_guests' => 'required',
            'number_of_rooms' => 'required',
            'price_per_night' => 'required',
            'property_type_id' => 'required',
            'city_id' => 'required',
            'full_address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'postal_code' => 'required',
            'is_listed' => 'required',
        ]);

        Property::create([
            'name' => $request->name,
            'description' => $request->description,
            'space_sqm' => $request->space_sqm,
            'max_guests' => $request->max_guests,
            'number_of_rooms' => $request->number_of_rooms,
            'price_per_night' => $request->price_per_night,
            'property_type_id' => $request->property_type_id,
            'city_id' => $request->city_id,
            'full_address' => $request->full_address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'postal_code' => $request->postal_code,
            'is_listed' => $request->is_listed ? 1 : 0
        ]);

        session()->flash('success', 'Created successfully');

        return redirect()->route('admin.properties.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $property = Property::find($id);

        if($property) {
            $propertyTypes = PropertyType::all();
            $cities = City::with('state.country')->get();
            $allowedDistance = setting('allowed_distance');
            $mapZoom = setting('map_zoom');

            return view('admin.properties.edit', compact('property', 'propertyTypes', 'cities', 'allowedDistance', 'mapZoom'));
        } else {
            session()->flash('error', 'Property not found');

            return redirect()->route('admin.properties.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'space_sqm' => 'required',
            'max_guests' => 'required',
            'number_of_rooms' => 'required',
            'price_per_night' => 'required',
            'property_type_id' => 'required',
            'city_id' => 'required',
            'full_address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'postal_code' => 'required',
            'is_listed' => 'required',
        ]);

        $property = Property::find($id);

        if($property) {
            $property->update([
                'name' => $request->name,
                'description' => $request->description,
                'space_sqm' => $request->space_sqm,
                'max_guests' => $request->max_guests,
                'number_of_rooms' => $request->number_of_rooms,
                'price_per_night' => $request->price_per_night,
                'property_type_id' => $request->property_type_id,
                'city_id' => $request->city_id,
                'full_address' => $request->full_address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'postal_code' => $request->postal_code,
                'is_listed' => $request->is_listed ? 1 : 0
            ]);

            session()->flash('success', 'Updated successfully');

            return redirect()->route('admin.properties.index');
        } else {
            session()->flash('error', 'Property not found');

            return redirect()->route('admin.properties.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $property = Property::find($id);

        if($property) {
            $property->delete();

            session()->flash('success', 'Deleted successfully');

            return redirect()->route('admin.properties.index');
        } else {
            session()->flash('error', 'Property not found');

            return redirect()->route('admin.properties.index');
        }
    }

    public function data(Request $request)
    {
        $properties = Property::select();

        return DataTables::of($properties)
            ->editColumn('created_at', function (Property $property) {
                return $property->created_at->format('Y-m-d');
            })
            ->addColumn('actions', 'admin.properties.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }
}
