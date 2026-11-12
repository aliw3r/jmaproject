<?php

namespace App\Http\Controllers;

use App\Models\AvatarRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AvatarRequestController extends Controller
{
    // ==================== ПОЛЬЗОВАТЕЛЬСКИЕ МЕТОДЫ ====================
    
    // Страница профиля (если используем этот контроллер для профиля)
     public function index()
    {
        $user = auth()->user();
        
        if (!$user) {
            return redirect()->route('auth');
        }
        
        $pendingRequest = $user->getPendingAvatarRequest();
        $rejectedRequest = $user->avatarRequests()
            ->where('status', 'rejected')
            ->where('is_notified', false) // Добавим поле для отслеживания
            ->latest()
            ->first();
        
        return view('profile', compact('user', 'pendingRequest', 'rejectedRequest'));
    }

    // Отправка запроса на смену аватарки
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Проверяем, есть ли уже ожидающий запрос
        if ($user->hasPendingAvatarRequest()) {
            return back()->with('error', 'У вас уже есть ожидающий запрос на смену аватарки. Дождитесь решения администратора.');
        }

        // Сохраняем новый аватар во временную папку
        $path = $request->file('avatar')->store('avatars/pending', 'public');
        $newAvatarPath = $path; // Сохраняем относительный путь

        // Сохраняем старую аватарку (если есть) - ИСПРАВЛЕННАЯ ВЕРСИЯ
        $oldAvatar = null;
        
        // Получаем значение аватарки напрямую из модели
        $currentAvatar = $user->getOriginal('avatar');
        
        if ($currentAvatar && $currentAvatar !== 'avatars/default.png') {
            $oldAvatar = $currentAvatar;
        }

        // Создаем запрос
        AvatarRequest::create([
            'user_id' => $user->id,
            'new_avatar' => $newAvatarPath,
            'old_avatar' => $oldAvatar,
            'status' => 'pending',
        ]);

        return redirect()->route('profile')
            ->with('success', 'Запрос на смену аватарки отправлен. Ожидайте подтверждения администратора.');
    }

    // Отмена запроса (для пользователя)
    public function cancel($id)
    {
        $request = AvatarRequest::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        // Удаляем временный файл
        if ($request->new_avatar) {
            Storage::disk('public')->delete($request->new_avatar);
        }

        $request->delete();

        return redirect()->route('profile')
            ->with('success', 'Запрос на смену аватарки отменен.');
    }
    public function markNotificationAsRead()
    {
        $user = auth()->user();
        
        $user->avatarRequests()
            ->where('status', 'rejected')
            ->where('is_notified', false)
            ->update(['is_notified' => true]);
        
        return redirect()->route('profile');
    }


    // ==================== АДМИНСКИЕ МЕТОДЫ ====================

    // Список всех запросов на смену аватарки
    public function adminIndex()
    {
        $requests = AvatarRequest::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('avatar-requests', compact('requests'));
    }

    // Одобрение запроса
    public function approve($id)
    {
        $avatarRequest = AvatarRequest::findOrFail($id);
        $user = $avatarRequest->user;

        // Обновляем аватар пользователя
        $user->avatar = $avatarRequest->new_avatar;
        $user->save();

        // Обновляем статус запроса
        $avatarRequest->status = 'approved';
        $avatarRequest->reviewed_at = now();
        $avatarRequest->save();

        // Удаляем старый аватар (если он существует и не дефолтный)
        if ($avatarRequest->old_avatar && 
            $avatarRequest->old_avatar !== 'avatars/default.png') {
            if (Storage::disk('public')->exists($avatarRequest->old_avatar)) {
                Storage::disk('public')->delete($avatarRequest->old_avatar);
            }
        }

        return redirect()->route('admin.avatar-requests')
            ->with('success', 'Аватарка одобрена и применена.');
    }

    // Отклонение запроса
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $avatarRequest = AvatarRequest::findOrFail($id);

        if ($avatarRequest->new_avatar) {
            if (Storage::disk('public')->exists($avatarRequest->new_avatar)) {
                Storage::disk('public')->delete($avatarRequest->new_avatar);
            }
        }

        $avatarRequest->status = 'rejected';
        $avatarRequest->rejection_reason = $request->rejection_reason;
        $avatarRequest->reviewed_at = now();
        $avatarRequest->is_notified = false; // Пользователь ещё не уведомлен
        $avatarRequest->save();

        return redirect()->route('admin.avatar-requests')
            ->with('success', 'Запрос отклонен. Пользователь получит уведомление.');
    }
}