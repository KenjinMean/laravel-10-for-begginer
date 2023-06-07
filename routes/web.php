<?php

use App\Http\Controllers\Auth\GithubAuthController;
use App\Models\User;
use App\Models\GithubUser;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Profile\CoverController;
use App\Http\Controllers\Profile\AvatarController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
  Route::patch('/profile/cover', [CoverController::class, 'update'])->name('profile.cover');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

/*
NOTE: feature to add
  add google auth
  add facebook auth
  add Route:: to handle all auth route
  
  Route::get('/auth/github/redirect', [SocialAuthController::class, 'redirect'])->name('auth.github.redirect');
  Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect'])->name('auth.google.redirect');
  Route::get('/auth/facebook/redirect', [SocialAuthController::class, 'redirect'])->name('auth.facebook.redirect');
  Route::get('/auth/linkedin/redirect', [SocialAuthController::class, 'redirect'])->name('auth.linkedin.redirect');

  
*/
// Route::get('/auth/google/redirect', [GithubAuthController::class, 'redirect'])->name('github.redirect');
// Route::get('/auth/facebook/redirect', [GithubAuthController::class, 'redirect'])->name('github.redirect');
// Route::get('/auth/linkedin/redirect', [GithubAuthController::class, 'redirect'])->name('github.redirect');


#github login routes
Route::get('/auth/github/redirect', [GithubAuthController::class, 'redirect'])->name('github.redirect');
Route::get('/auth/github/callback', [GithubAuthController::class, 'callback'])->name('github.callback');
