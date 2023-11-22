<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use App\Http\Resources\GaleriResource;
use Illuminate\Support\Facades\Storage;

class GaleriApiController extends Controller
{
    public function index()
    {
        $galeri = Galeri::all();
        return GaleriResource::collection($galeri);
    }

    public function store(Request $request)
    {
        $galeri = Galeri::create([
            'photo'=>$request['photo']
        ]);

        return new GaleriResource($galeri);
    }
}
