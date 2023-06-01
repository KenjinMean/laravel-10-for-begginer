<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;

class AvatarController extends Controller {
    public function update(UpdateAvatarRequest $request) {
        $path = $request->file('avatar')->store('avatars');
        $path = str_replace('/', '\\', $path);
        auth()->user()->update(['avatar' => storage_path('app\\' . "$path")]);
        return back()->with('message', 'Avatar is updated.');
    }
}
