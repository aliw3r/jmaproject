<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Song;
use App\Models\User;
use App\Models\AvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // ==================== ГЛАВНАЯ СТРАНИЦА ====================
    public function index()
    {
        $songs = Song::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('songs'));
    }

    public function home()
    {
        $songs = Song::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('songs'));
    }

    // ==================== РЕГИСТРАЦИЯ ====================
    public function register()
    {
        return view('register');
    }

    public function registerform(RegisterRequest $request)
    {
        // Обработка аватарки
        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        // Создаем пользователя с полем avatar (не avatar_url)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $avatarPath, // Сохраняем путь к аватарке
            'role' => 'client',
            'is_active' => false,
            'approved_at' => null,
            'is_blocked' => false,
        ]);

        return redirect()->route('register')
            ->with('success', 'Ваша заявка отправлена на модерацию! Ожидайте подтверждения.');
    }

    // ==================== АВТОРИЗАЦИЯ ====================
    public function auth()
    {
        return view('auth');
    }

    public function authform(AuthRequest $request)
    {
        // Проверяем, активен ли пользователь
        $user = User::where('name', $request->name)->first();

        if ($user && !$user->isActive()) {
            return back()
                ->withInput($request->only('name'))
                ->withErrors(['name' => 'Ваш аккаунт ещё не активирован. Пожалуйста, дождитесь подтверждения администратором.']);
        }

        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            $songs = Song::orderBy('created_at', 'desc')->get();
            return view('welcome', compact('songs'));
        }

        return back()
            ->withInput($request->only('name'))
            ->withErrors(['password' => 'Неверное имя пользователя или пароль']);
    }

    // ==================== ВЫХОД ====================
    public function logout()
    {
        Auth::logout();
        $songs = Song::orderBy('created_at', 'desc')->get();
        return view('welcome', compact('songs'));
    }

    // ==================== ПРОФИЛЬ ====================
    public function profile()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('auth');
        }

        $pendingRequest = $user->getPendingAvatarRequest();
        $rejectedRequest = $user->avatarRequests()
            ->where('status', 'rejected')
            ->where('is_notified', false)
            ->latest()
            ->first();

        return view('profile', compact('user', 'pendingRequest', 'rejectedRequest'));
    }
}
