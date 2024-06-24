<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Http\Resources\PropertyResource;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::whenSearch(request()->search)
            ->paginate(10);

        $data['properties'] = PropertyResource::collection($properties)->response()->getData();

        return response()->api($data);
    }

    public function toggleWishList()
    {
        auth()->user()->wishListProperties()->toggle([request()->property_id]);

        return response()->api(null, 0, 'Property toggled successfully');
    }

    public function search(Request $request)
    {
        // Validate the request parameters
        $request->validate([
            'search' => 'nullable|string|max:255',
            'bounds.southWest.lat' => 'required|numeric',
            'bounds.southWest.lng' => 'required|numeric',
            'bounds.northEast.lat' => 'required|numeric',
            'bounds.northEast.lng' => 'required|numeric',
            'page' => 'nullable|integer|min:1',
        ]);

        $search = $request->get('search');
        $bounds = $request->get('bounds');
        $page = $request->get('page', 1);
        $perPage = 15; // Number of items per page

        $propertiesQuery = Property::whenSearch($search)
            ->whereBetween('latitude', [$bounds['southWest']['lat'], $bounds['northEast']['lat']])
            ->whereBetween('longitude', [$bounds['southWest']['lng'], $bounds['northEast']['lng']]);

        $total = $propertiesQuery->count();

        $allProperties = $propertiesQuery->get();
        $paginatedProperties = $propertiesQuery->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        return response()->json([
            'all_properties' => $this->transformPropertiesResponse($allProperties),
            'paginated_properties' => $this->transformPropertiesResponse($paginatedProperties),
            'total' => $total,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ]);
    }

    private function transformPropertiesResponse($properties)
    {
        $propertiesData = $properties->map(function ($property) {
            return [
                'id' => $property->id,
                'name' => $property->name ?? 'Sea Breezes',
                'latitude' => $property->latitude ?? 25.206426,
                'longitude' => $property->longitude ?? 55.346465,
                'map_image_url' => $property->map_image_url ?? '../../assets/images/property/1.jpg',
                'slider_images_urls' => [
                    '../../assets/images/property/1.jpg',
                    '../../assets/images/property/2.jpg',
                    '../../assets/images/property/3.jpg',
                    '../../assets/images/property/4.jpg',
                ],
                'price_per_night' => $property->price_per_night ?? '$1200',
                'label' => $property->label ?? 'for sale',
                'bed' => $property->bed ?? '4',
                'bath' => $property->bath ?? '4',
                'sqft' => $property->sqft ?? '5000',
                'title' => $property->title ?? 'first',
                'url' => $property->url ?? '/properties/' . $property->id,
                'description' => $property->description ?? 'No description available',
                'date' => $property->created_at->format('F d, Y')
            ];
        });

        return $propertiesData->toArray();
    }
}
