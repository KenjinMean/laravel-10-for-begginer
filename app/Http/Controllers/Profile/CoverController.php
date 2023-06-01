<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateCoverRequest;

class CoverController extends Controller {
    public function update(UpdateCoverRequest $request) {

        $path = $request->file('cover')->store('covers');
        $path = str_replace('/', '\\', $path);

        $user = Auth::user();

        $user->cover = storage_path('app\\' . $path);
        $user->save();

        // auth()->user()->update(['cover' => storage_path('app\\' . "$path")]);

        return back()->with('message', 'Cover is updated.');
    }
}
