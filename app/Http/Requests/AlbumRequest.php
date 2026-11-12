<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'artist_id' => 'required|exists:artists,id',
            'type' => 'required|in:single,ep,album,compilation,live',
            'release_year' => 'required|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string|max:2000',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Название альбома обязательно',
            'artist_id.required' => 'Выберите исполнителя',
            'release_year.required' => 'Укажите год выпуска',
        ];
    }
}