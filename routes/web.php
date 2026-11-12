<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\AvatarRequestController;

// ==================== ГЛАВНАЯ СТРАНИЦА ====================
Route::get('/', [UserController::class, 'index'])->name('index');
Route::get('/home', [UserController::class, 'home'])->name('home');

// ==================== АУТЕНТИФИКАЦИЯ ====================
Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/registerform', [UserController::class, 'registerform'])->name('registerform');
Route::get('/auth', [UserController::class, 'auth'])->name('auth');
Route::post('/authform', [UserController::class, 'authform'])->name('authform');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// ==================== ПОИСК ====================
Route::get('/search', [SearchController::class, 'search'])->name('search');

// ==================== ПРОФИЛЬ (только авторизованные) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    
    // Запросы на смену аватарки (через отдельный контроллер)
    Route::post('/avatar/request', [AvatarRequestController::class, 'store'])->name('avatar.request');
    Route::delete('/avatar/cancel/{id}', [AvatarRequestController::class, 'cancel'])->name('avatar.cancel');

    Route::post('/avatar/request', [AvatarRequestController::class, 'store'])->name('avatar.request');
    Route::delete('/avatar/cancel/{id}', [AvatarRequestController::class, 'cancel'])->name('avatar.cancel');
    Route::post('/avatar/notification/read', [AvatarRequestController::class, 'markNotificationAsRead'])->name('avatar.notification.read');
});

// ==================== АДМИН ПАНЕЛЬ ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Управление пользователями
    Route::get('/pending-users', [AdminController::class, 'pendingUsers'])->name('admin.pending-users');
    Route::post('/users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::delete('/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('admin.users.reject');
    Route::post('/users/{id}/block', [AdminController::class, 'blockUser'])->name('admin.users.block');
    
    // Управление запросами на аватарку
    Route::get('/avatar-requests', [AvatarRequestController::class, 'adminIndex'])->name('admin.avatar-requests');
    Route::post('/avatar-requests/{id}/approve', [AvatarRequestController::class, 'approve'])->name('admin.avatar.approve');
    Route::post('/avatar-requests/{id}/reject', [AvatarRequestController::class, 'reject'])->name('admin.avatar.reject');
});

// ==================== ДОБАВЛЕНИЕ КОНТЕНТА (только админы) ====================
Route::middleware(['auth', 'admin'])->group(function () {
    // Треки
    Route::get('/song/add', [SongController::class, 'SongAdd'])->name('SongAdd');
    Route::post('/song/add', [SongController::class, 'SongForm'])->name('SongForm');

    // Артисты
    Route::get('/artist/add', [ArtistController::class, 'ArtistAdd'])->name('ArtistAdd');
    Route::post('/artist/add', [ArtistController::class, 'ArtistForm'])->name('ArtistForm');

    // Альбомы
    Route::get('/album/add', [AlbumController::class, 'AlbumAdd'])->name('AlbumAdd');
    Route::post('/album/add', [AlbumController::class, 'AlbumForm'])->name('AlbumForm');

    // Награды
    Route::get('/award/assign/{type}/{id}', [AwardController::class, 'AwardAssign'])->name('AwardAssign');
    Route::post('/award/store', [AwardController::class, 'AwardStore'])->name('AwardStore');
    Route::delete('/award/remove/{id}', [AwardController::class, 'AwardRemove'])->name('AwardRemove');
});

// ==================== СТРАНИЦЫ ПРОСМОТРА (ДИНАМИЧЕСКИЕ) ====================
Route::get('/song/{id}', [SongController::class, 'song'])->name('song');
Route::get('/artist/{id}', [ArtistController::class, 'ArtistPage'])->name('artist');
Route::get('/album/{id}', [AlbumController::class, 'AlbumPage'])->name('album');