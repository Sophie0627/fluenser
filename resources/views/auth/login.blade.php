@extends('layouts.app')

@section('content')

<main>
    <div class="max-full md:max-w-xl mx-auto py-6 sm:px-6 lg:px-8 mt-20">
    <div class="w-full">
        <a href="{{route('welcome')}}" class="block mx-auto mb-10" style="max-width: 150px;">
            <img class="w-full" src="{{ asset('img/logo.jpg') }}" alt="logo">
        </a>
    </div>
        <div class="w-11/12 mx-auto bg-gray-100 rounded-2xl py-3" style="font-family: 'Poppins', sans-serif;">
            <div class="w-11/12 mx-auto">
                <!-- Replace with your content -->
                <p class="text-center text-2xl">Welcome Back</p>
                <hr>
                <div class="py-6 sm:px-0 w-full mx-auto">
                  <form method="POST" action="{{ route('login') }}" class="mx-auto">
                      @csrf
                      <label class="block mb-8">
                          <input id="email" type="email" class="h-10 form-input mt-2 block w-full @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email or Username" style="border:1px solid #999; padding:25px 15px;">
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <label class="block mb-6">
                          <input id="password" type="password" class="h-10 form-input mt-2 block w-full @error('password') is-invalid @enderror" name="password" required placeholder="Password" style="border:1px solid #999; padding: 25px 15px;">
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                      </label>
                      <div class="flex justify-between mt-2">
                          <div>
                              <label class="flex items-center">
                                <input class="form-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="ml-2 text-sm">{{ __('Remember Me') }}</span>
                              </label>
                          </div>
                          <div>
                            @if (Route::has('password.request'))
                            <label class="flex items-center">
                                <a class="text-sm text-blue-500" href="{{ route('password.request') }}">
                                    {{ __('Forgot Password?') }}
                                </a>
                            </label>
                            @endif
                          </div>
                      </div>
                      <div class="flex mt-6 w-2/3 mx-auto">
                          <button type="submit" class="w-full appearance-none text-white text-lg md:text-xl font-semibold tracking-wide rounded hover:bg-blue-900" style="background:#0ac2c8; padding:15px;"> {{ __('Sign In') }} </button>
                      </div>
                  </form>
                </div>
                <!-- /End replace -->
            </div>
        </div>
        <div class="mt-8 text-center">
            @if (Route::has('register'))
                <p class="text-sm">Don`t have an account?<a href="{{ route('register') }}" class="text-blue-500">&nbsp;&nbsp;Sign Up</a></p>
            @endif
        </div>
    </div>
</main>
@endsection
