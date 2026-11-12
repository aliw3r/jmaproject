<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed', // confirmed проверяет password_confirmation
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Имя обязательно для заполнения',
            'name.unique' => 'Это имя уже занято или находится на модерации',
            'email.required' => 'Email обязателен для заполнения',
            'email.email' => 'Введите корректный email',
            'email.unique' => 'Этот email уже зарегистрирован или находится на модерации',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.min' => 'Пароль должен быть минимум 6 символов',
            'password.confirmed' => 'Пароли не совпадают',
            'avatar.image' => 'Файл должен быть изображением',
            'avatar.mimes' => 'Допустимые форматы: jpeg, png, jpg, gif, webp',
            'avatar.max' => 'Размер файла не должен превышать 2MB',
        ];
    }
}