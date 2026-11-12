<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Artist;
use App\Models\Album;
use App\Http\Requests\SongRequest;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    // Страница одного трека
    public function song($id)
    {
        $song = Song::with(['artist', 'album', 'awards.award'])->findOrFail($id);
        return view('song', compact('song'));
    }

    // Страница добавления трека
    public function SongAdd()
    {
        // Передаем списки артистов и альбомов для выбора
        $artists = Artist::orderBy('name')->get();
        $albums = Album::orderBy('name')->get();
        return view('SongAdd', compact('artists', 'albums'));
    }

    // Обработка формы добавления трека
    public function SongForm(SongRequest $request)
    {
        // Проверяем, существует ли артист
        $artist = Artist::findOrFail($request->artist_id);

        // Если указан альбом, проверяем, что он принадлежит этому артисту
        if ($request->album_id) {
            $album = Album::where('id', $request->album_id)
                         ->where('artist_id', $request->artist_id)
                         ->firstOrFail();
        }

        $song = new Song;
        $song->name = $request->name;
        $song->artist_id = $request->artist_id;
        $song->album_id = $request->album_id ?? null;
        $song->genre = $request->genre;
        $song->season = $request->season;
        $song->year = $request->year;
        $song->duration = $request->duration;
        
        // Обработка обложки
        if ($request->hasFile('oblozhka')) {
            $path = $request->file('oblozhka')->store('oblozhki', 'public');
            $song->oblozhka = '/storage/' . $path;
        }

        // Обработка аудиофайла (если есть)
        if ($request->hasFile('audio_file')) {
            $audioPath = $request->file('audio_file')->store('audio', 'public');
            $song->audio_file = '/storage/' . $audioPath;
        }

        $song->save();

        return redirect()->route('home')->with('success', 'Трек успешно добавлен!');
    }
}