<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Http\Requests\ArtistRequest;
use Illuminate\Support\Facades\Storage;

class ArtistController extends Controller
{
    public function ArtistAdd()
    {
        return view('ArtistAdd');
    }

    public function ArtistForm(ArtistRequest $request)
    {
        $artist = new Artist;
        $artist->name = $request->name;
        $artist->description = $request->description;
        $artist->country = $request->country;
        $artist->debut_year = $request->debut_year;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('artists', 'public');
            $artist->photo = '/storage/' . $path;
        }

        $artist->save();

        return redirect()->route('home')->with('success', 'Артист успешно добавлен!');
    }

    public function ArtistPage($id)
    {
        $artist = Artist::with(['albums', 'songs', 'awards.award'])->findOrFail($id);
        return view('artist', compact('artist'));
    }
}