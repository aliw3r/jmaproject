<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SongRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user() && auth()->user()->isAdmin(); // проверка на админа
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'album_id' => 'nullable|exists:albums,id',
            'genre' => 'required|string|max:100',
            'season' => 'required|string|max:50',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'duration' => 'nullable|string|max:10',
            'oblozhka' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio_file' => 'nullable|file|mimes:mp3,wav,flac|max:10240',
        ];
    }
}