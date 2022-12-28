<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="{{ url('img/pashmina.png') }}" width="300" class=" fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            
            
            
            <!-- Email Address -->
            <div>
                <div class="form-control mt-6">
                    <label class="label">
                      <span class="label-text">Employee No</span>
                    </label>
                    <input type="text" name="employee" placeholder="Employee No" class="input input-bordered" />
                </div>

                {{-- <x-text-input id="employee" class="block mt-1 w-full" type="text" name="employee" :value="old('employee')" required autofocus /> --}}

                <x-input-error :messages="$errors->get('employee')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <div class="form-control">
                    <label class="label">
                      <span class="label-text">Password</span>
                    </label>
                    <input type="password" name="password" placeholder="Password" class="input input-bordered" />
                    
                  </div>
                {{-- <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" /> --}}

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            {{-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> --}}

            {{-- <div class="flex items-center justify-end mt-4"> --}}
                {{-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif --}}
                <div class="form-control mt-6 mb-6">
                    <button class="btn btn-primary">Masuk</button>
                  </div>
                {{-- <x-primary-button class="form-control mt-6">
                    {{ __('Log in') }}
                </x-primary-button> --}}
            {{-- </div> --}}
        </form>
    </x-auth-card>
</x-guest-layout>
