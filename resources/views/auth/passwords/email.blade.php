@extends('layouts.app')
@section('content')
<div class="w-full max-w-xl mx-auto">
    <div class="mx-auto w-11/12">
      @if (session('status'))
      <div class="w-full relative" style="height: 100vh">
        <div class="w-full absolute left-0" style="top: 50%; transform:translateY(-50%);">
          <div class="w-1/3 mx-auto">
            <img src="{{ asset('img/mail.png') }}" alt="mail" class="w-full">
          </div>
          <div class="text-center mt-5">
            <p class="text-2xl md:text-3xl font-bold">Check Your Mail</p>
            <p class="text-sm mt-3">We have sent a password recover instructions to your email.</p>
          </div>
        </div>
        <div class="left-0 absolute bottom-10 text-center w-full ">
          <p class="text-sm">Did not receive the email? Check your spam filter,<br/> or <a onclick="document.location.reload();"><span class="text-blue-500">try another email address</span></a></p>
        </div>
      </div>
      @else
        <div class="w-full mt-3">
            <a href="{{ route('login') }}" class="text-xl text-gray-500">
                <i class="fas fa-chevron-left"></i>
            </a>
        </div>
        <div class="w-1/3 mx-auto mt-20">
            <img src="{{ asset('img/reset.png') }}" alt="reset">
        </div>
        <div class="title mt-5">
            <p class="text-2xl md:text-3xl text-center font-bold">
                {{ __('Forget Password?') }}
            </p>
            <p class="text-md md:text-lg text-center mt-3">
                {{ __('Enter your e-mail address below to receive an e-mail with your password reset instruction.') }}
            </p>
        </div>
        <div class="w-full mt-5">
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="col-form-label text-xs">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="w-full @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus style="padding: 15px 15px;">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group  mt-5">
                    <div class='w-full'>
                      <button type="submit" class="block w-full text-white font-bold text-lg rounded" style="background: #0ac2c8;padding: 12px;">
                          {{ __('Send Instructions') }}
                      </button>
                    </div>
                </div>
            </form>
        </div>
      @endif
    </div>
</div>
@endsection
