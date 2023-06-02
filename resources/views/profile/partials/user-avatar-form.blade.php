<section>
  <header>
    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
      User Avatar
    </h2>

    <div style="width: 150px; height: 150px; border-radius: 100%; overflow: hidden;">
      <img style="width: 100%; height: 100%; object-fit: cover" class="" src="{{"/storage/$user->avatar"}}" alt="user avatar">
    </div>

    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
      update user avatar
    </p>
  </header>

  @if (session('message'))
    <div class="text-green-600">
      {{ session('message') }}
    </div>
  @endif

  <form method="post" action="{{ route('profile.avatar') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div>
      <x-input-label for="avatar" value="Avatar" />
      <x-text-input id="avatar" name="avatar" type="file" class="mt-1 block w-full" :value="old('avatar', $user->avatar)" autofocus
        autocomplete="avatar" required />
      <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
          class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>

  <form method="post" action="{{ route('profile.cover') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <div>
      <x-input-label for="cover" value="Cover" />
      <x-text-input id="cover" name="cover" type="file" class="mt-1 block w-full" :value="old('cover', $user->cover)" autofocus
        autocomplete="cover" required/>
      <x-input-error class="mt-2" :messages="$errors->get('cover')" />
    </div>

    <div class="flex items-center gap-4">
      <x-primary-button>{{ __('Save') }}</x-primary-button>

      @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
          class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
      @endif
    </div>
  </form>
</section>
