<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreGaleriRequest;
use App\Http\Requests\UpdateGaleriRequest;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $galeri = Galeri::all();
    //     return view('index', [
    //         "galeri" => $galeri
    //     ]);
    // }

    // index API
    public function index(){
        $galeri = Http::get('http://127.0.0.1:9000/api/galeri');
        // dd($galeri->json()['data'][0]['id']);
        return view('index', [
            "galeries" => $galeri->json()['data']
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    // public function store(Request $request){
    //     $response = Http::post('http://127.0.0.1:9000/api/galeri', [
    //          'photo' => $request->photo
    //     ]);
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $galeri = Galeri::all();

        // Check if the request data is received correctly
        $validated = $request->validate([
            'photo' => 'image|nullable|max:2048'
        ]);

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $filename = time() . '.' . $request->file('photo')->getClientOriginalExtension();

            Storage::put('/photo/' . $filename, $request->file('photo')->get());

            $validated['photo'] = $filename;

            Http::post('http://127.0.0.1:9000/api/galeri', ['photo' => $filename]);

        } else {
            return redirect()->back()->withErrors(['photo' => 'Invalid photo file.']);
        }

        // Pass the image path directly to the view
        return redirect('/galeri');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        return view('/edit', [
            'galeri' => $galeri
        ]);
    }


    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'photo' => 'image|nullable|max:2048'
        ]);

        $galeri = Galeri::findOrFail($id);


        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {

            Storage::delete('/photo/' . $galeri->photo);

            $filename = time() . '.' . $request->file('photo')->getClientOriginalName();

            Storage::put('/photo/' . $filename, $request->file('photo')->get());

            $validate['photo'] = $filename;
        } else {
            return redirect()->back()->withErrors(['photo' => 'Invalid photo file.']);
        }

        $galeri->photo = $validate['photo'];
        $galeri->save();


        return redirect('/galeri');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $galeri = Galeri::findOrFail($id);
        $galeri->delete();
        Storage::delete('/photo/' . $galeri->photo);

        return redirect('/galeri');
    }
}
