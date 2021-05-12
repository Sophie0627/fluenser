@extends('layouts.app')

@section('content')
<div class="w-full max-w-xl mx-auto">
    <div class="mx-auto w-11/12">
        <div class="w-full mt-3">
            <a href="{{ route('login') }}" class="text-gray-500 text-xl"><i class="fas fa-chevron-left"></i></a>
        </div>
        <div class="mt-5">
            <p class="text-2xl md:text-3xl font-bold">Create new password</p>
            <p class="text-sm mt-3 text-gray-500">Your new password must be different from previous used passwords.</p>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mt-3 hidden">
                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="w-full rounded @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="password" class="text-sm ">{{ __('Password') }}</label>

                    <div class="relative">
                        <input id="password" type="password" class="w-full rounded @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="padding: 12px 15px;">
                        <a class="block absolute right-2" id="togglePassword" style="top: 50%; transform:translateY(-50%);" onclick="togglePassword()"><i class="fas fa-eye"></i></a>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <p class="text-xs text-gray-500">Must be at least 8 characters.</p>
                </div>

                <div class="mt-3">
                    <label for="password-confirm" class="text-sm">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="w-full rounded" name="password_confirmation" required autocomplete="new-password" style="padding: 12px 15px;">
                    </div>
                </div>
                <p class="text-xs text-gray-500">Both passwords must match.</p>

                <div class="mt-5 mb-0">
                    <div>
                        <button type="submit" class="w-full rounded text-white text-xl font-bold" style="padding: 12px; background:#0ac2c8" >
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function togglePassword() {
        if($("input#password").attr('type') == 'password') {
            $("input#password").attr('type', 'text');
            $("a#togglePassword i").removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $("input#password").attr('type', 'password');
            $("a#togglePassword i").removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }
</script>
@endsection
