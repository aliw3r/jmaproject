<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArtistRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:100',
            'debut_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'description' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Имя артиста обязательно для заполнения',
            'photo.image' => 'Файл должен быть изображением',
            'photo.max' => 'Размер фото не должен превышать 2MB',
        ];
    }
}