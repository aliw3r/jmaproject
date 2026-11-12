<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Http\Requests\AlbumRequest;

class AlbumController extends Controller
{
    public function AlbumAdd()
    {
        $artists = Artist::orderBy('name')->get();
        return view('AlbumAdd', compact('artists'));
    }

    public function AlbumForm(AlbumRequest $request)
    {
        $album = new Album;
        $album->name = $request->name;
        $album->artist_id = $request->artist_id;
        $album->description = $request->description;
        $album->release_year = $request->release_year;
        $album->type = $request->type;

        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('albums', 'public');
            $album->cover = '/storage/' . $path;
        }

        $album->save();

        return redirect()->route('home')->with('success', 'Альбом успешно добавлен!');
    }

    public function AlbumPage($id)
    {
        $album = Album::with(['artist', 'songs', 'awards.award'])->findOrFail($id);
        return view('album', compact('album'));
    }
}