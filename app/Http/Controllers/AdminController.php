<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // Список пользователей на модерации
    public function pendingUsers()
    {
        // Ожидают модерации
        $pendingUsers = User::where('is_active', false)->whereNull('approved_at')->orderBy('created_at', 'desc')->get();
        
        // Активные пользователи
        $activeUsers = User::where('is_active', true)
                          ->whereNotNull('approved_at')
                          ->orderBy('approved_at', 'desc')
                          ->get();
        
        return view('pending-users', compact('pendingUsers', 'activeUsers'));
    }

    // Одобрить пользователя
    public function approveUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_active && $user->approved_at !== null) {
            return back()->with('error', 'Пользователь уже активирован');
        }

        $user->update([
            'is_active' => true,
            'approved_at' => now()
        ]);

        return redirect()->route('admin.pending-users')->with('success', "Пользователь {$user->name} успешно активирован!");
    }

    // Отклонить пользователя (удалить)
    public function rejectUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->is_active && $user->approved_at !== null) {
            return back()->with('error', 'Нельзя удалить активированного пользователя');
        }

        // Удаляем аватар
        if ($user->avatar && $user->avatar != 'avatars/default.png') {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }

        $user->delete();

        return redirect()->route('admin.pending-users')->with('success', 'Пользователь удален');
    }

    // Заблокировать пользователя
    public function blockUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->with('error', 'Нельзя заблокировать администратора');
        }

        $user->update([
            'is_active' => false,
            'approved_at' => null
        ]);

        return redirect()->route('admin.pending-users')->with('success', "Пользователь {$user->name} заблокирован");
    }
}