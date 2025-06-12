<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorewikulinerRequest;
use App\Http\Requests\UpdatewikulinerRequest;
use App\Models\wikuliner;
use Illuminate\Http\Request;
use App\Models\User;

class WikulinerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth('sanctum')->user();
        $wikul = $user ? wikuliner::where('id_user', null)->orWhere('id_user', $user->id_user)->get() : wikuliner::where('id_user', null)->get();
        return response()-> json([
            'success' => true,
            'message' => "Berhasil mengambil data tempat wisata dan kuliner",
            'data' => $wikul->map(function ($wikul) use ($user) {
                return [
                    'id_wikul' => $wikul->id_wikul,
                    'name' => $wikul->name,
                    'rating' => $wikul->rating,
                    'mine' => $user && $wikul->id_user === $user->id_user ? "1" : "0"
                ];
            })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getImage($id_wikul) {
        $wikul = wikuliner::find($id_wikul);

        if ($wikul) {
            $path = public_path($wikul->imageUrl);
            return response()->file($path);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorewikulinerRequest $request)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "rating" => ["required", "string"],
            "image" => ["required", "image"],
        ]);

        $image = $request->image;
        $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('gambar'), $filename);

        $wikul = wikuliner::create([
            "id_user" => $request->user()->id_user,
            'name' => $request->name,
            'rating' => $request->rating,
            'imageUrl' => "gambar/$filename"
        ]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil menambahkan tempat wisata dan kuliner"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(wikuliner $wikuliner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(wikuliner $wikuliner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatewikulinerRequest $request, wikuliner $wikuliner, $id_wikul)
    {
        $request->validate([
            "name" => ["required", "string", "max:255"],
            "rating" => ["required", "string"],
            "image" => ["image"],
        ]);

        $wikul = wikuliner::find($id_wikul);

        if(!$wikul) {
            return response()->json([
                'success' => false,
                'message' => "Tempat wisata dan kuliner tidak ditemukan"
            ]);
        }

        if ($wikul->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $image = $request->image;
        if ($image) {
            $filename = 'image_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('gambar'), $filename);
            $wikul->imageUrl = "gambar/$filename";
        }

        $wikul->name = $request->name;
        $wikul->rating = $request->rating;
    
        $wikul->save();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diupdate',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, wikuliner $wikuliner, $id_wikul)
    {
        $wikul = wikuliner::find($id_wikul);

        if (!$wikul) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        if ($wikul->id_user != $request->user()->id_user) {
            return response()->json([
                'success' => false,
                'message' => 'Data bukan milik anda',
            ]);
        }

        $wikul->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
