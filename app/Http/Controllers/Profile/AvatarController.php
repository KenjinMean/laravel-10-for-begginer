<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateAvatarRequest;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller {
  public function update(UpdateAvatarRequest $request) {
    // $path = $request->file('avatar')->store('public\avatars');
    // $path = $request->file('avatar')->store('avatars', 'public');
    $path = Storage::disk('public')->put('avatars', $request->file('avatar'));
    $path = str_replace('\\', '/', $path);

    // remove old avatar if not equal to default avatar
    $oldAvatar = $request->user()->avatar;

    if ($oldAvatar !== "avatars/default-avatar.png") {
      Storage::disk('public')->delete($oldAvatar);
    }

    auth()->user()->update(['avatar' => $path]);

    return back()->with('message', 'Avatar is updated.');
  }
}
