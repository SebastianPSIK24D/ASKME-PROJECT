<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Perbarui informasi profil dan alamat email akun Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>
        <div x-data="{ showModal: false, modalImage: '' }">
            <x-input-label for="avatar" :value="__('Foto Profil')" />
            <div class="mt-2 flex items-center gap-4">
                <div id="current-avatar-container">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}"
                             alt="Avatar Saat Ini"
                             class="w-20 h-20 rounded-full object-cover border border-gray-300 dark:border-gray-600 shadow-sm cursor-pointer hover:opacity-80 transition"
                             @click="modalImage = $el.src; showModal = true">
                    @else
                        <div class="w-20 h-20 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center border border-gray-300 dark:border-gray-500 overflow-hidden">
                            <svg class="w-18 h-18 text-gray-400 dark:text-gray-300 mt-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <img id="avatar-preview"
                     class="hidden w-20 h-20 rounded-full object-cover border-4 border-green-300 hover:border-green-500 shadow-md cursor-pointer transition duration-200"
                     alt="Preview Avatar Baru"
                     @click="modalImage = $el.src; showModal = true">
                <div class="flex-1">
                    <input id="avatar" name="avatar" type="file" accept="image/*" onchange="previewProfile(event)"
                           class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" />
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">JPG, PNG, atau GIF (Max. 2MB)</p>
                    <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                </div>
            </div>
            <div x-show="showModal"
                 style="display: none;"
                 class="fixed inset-0 z-[999] flex items-center justify-center bg-black bg-opacity-90 transition-opacity duration-300"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                <button type="button" @click="showModal = false" class="absolute top-5 right-5 text-white hover:text-gray-300 focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img :src="modalImage"
                     @click.away="showModal = false"
                     class="max-w-full max-h-screen p-4 rounded-lg shadow-2xl transform transition-transform duration-300"
                     x-transition:enter="scale-90 opacity-0"
                     x-transition:enter-end="scale-100 opacity-100">
            </div>
        </div>
        <script>
            function previewProfile(event) {
                const input = event.target;
                const currentContainer = document.getElementById('current-avatar-container');
                const previewImage = document.getElementById('avatar-preview');
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        currentContainer.classList.add('hidden');
                        previewImage.src = e.target.result;
                        previewImage.classList.remove('hidden');}
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
