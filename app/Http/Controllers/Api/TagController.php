<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    public function index() {
        $tags = Tag::all();

        return response()->api(TagResource::collection($tags));
    }
}
