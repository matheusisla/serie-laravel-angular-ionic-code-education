<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Resources\PhotoResource;
use App\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{

    public function index(Album $album)
    {
        //return $album->photos; //variavel é a coleção | método - criador de queries
        return PhotoResource::collection($album->photos);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Album $album)
    {
        $request->file('file_name')
            ->store($album->id);
        $fileName = $request->file('file_name')->hashName();
        $photo = Photo::create([
            'name' => $request->name,
            'album_id' => $album->id,
            'file_name' => $fileName
        ]);
        return new PhotoResource($photo);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Photo $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        //
    }

    public function photoUrl($photoName)
    {
        //retorna uma coleção de dados
        $photos = Photo::whereFileName($photoName)->get();
        if (!$photos->count()) {
            abort(404);
        }
        // pegando apenas o primeiro registro
        $photo = $photos->first();
        //recuperando o arquivo
        $photoPath = storage_path("app/{$photo->album_id}/{$photo->file_name}");
        //retornando o arquivo
        return response()->download($photoPath);
    }
}
