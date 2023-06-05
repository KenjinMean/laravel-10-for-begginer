<?php

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

#github login routes
Route::get('/auth/redirect', function () {
  return Socialite::driver('github')->redirect();
});

Route::get('/auth/callback', function () {
  $githubUser = Socialite::driver('github')->user();

  $name = $githubUser->name;
  if (empty($name)) {
    $name = $githubUser->nickname; // Use the nickname if the name is null
  }

  $githubUser = GithubUser::firstOrCreate(
    [
      'email' => $githubUser->email,
    ],
    [
      'github_id' => $githubUser->id,
      'name' => $name,
      'email' => $githubUser->email,
      'avatar' => 'avatars/default-avatar.png',
      'password' => bcrypt(Str::random(16)),
      'email_verified_at' => now(),
    ]
  );

  Auth::login($githubUser);
  return redirect('/dashboard');
});
