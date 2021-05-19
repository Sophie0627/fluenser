@extends('layouts.app')

@section('content')
<div id="deleteConfirm" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%; border-top:3px solid red" id="modalBody">
      <div class="w-10/12 mx-auto h-26 mt-4">
        <p class="text-center text-lg font-bold mb-2">Delete Account</p>
        <p class="text-center text-md md:text-lg text-gray-700 mt-2 mb-3">Are you sure you want to delete your account? If you delete your accout, you will permanently lose your profile, message and photos.</p>
      </div>
      <div class="w-full h-16" id="confirmBtn">
        <div class="w-full grid grid-cols-2 h-full">
          <div class="col-span-1 h-full">
            <button class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white" onclick="$('div#deleteConfirm').fadeOut(200)">Cancel</button>
          </div>
          <div class="col-span-1">
            <a class="w-full h-full block mx-auto px-4 py-4 rounded-br-lg text-white font-bold text-md md:text-lg bg-red-400 text-center" onclick="{{route('deleteAccount')}}"><span style="padding-top:">Yes</span></a>
          </div>
        </div>
      </div>
    </div>
</div>
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <span><a href="{{ route('home') }}" class="text-white"><i class="fas fa-chevron-left"></i></a></span>
    <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('ACCOUNT SETTINGS') }}</span>
  </div>
</header>
<div class="w-full max-w-xl mx-auto pb-40">
    <div class="mx-auto w-11/12">
        <div class="mt-5">
            <form method="POST" action="{{ route('updateAccount') }}">
                @csrf

                <div class="mt-3">
                  <label for="email" class="text-sm ">{{ __('Email') }}</label>

                    <div>
                        <input id="email" type="email" class="w-full rounded @error('email') is-invalid @enderror" name="email" value="{{ Auth::user()->email }}" required autocomplete="email" autofocus readonly>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="curPassword" class="text-sm ">{{ __('Current Password') }}</label>

                    <div class="relative">
                        <input id="curPassword" type="password" class="w-full rounded @error('curPassword') is-invalid @enderror" name="curPassword" required autocomplete="current-password" style="padding: 12px 15px;">
                        <a class="block absolute right-2" id="toggleCurPassword" style="top: 50%; transform:translateY(-50%);" onclick="toggleCurPassword()"><i class="fas fa-eye"></i></a>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="newPassword" class="text-sm ">{{ __('New Password') }}</label>

                    <div class="relative">
                        <input id="newPassword" type="password" class="w-full rounded @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="padding: 12px 15px;">
                        <a class="block absolute right-2" id="toggleNewPassword" style="top: 50%; transform:translateY(-50%);" onclick="toggleNewPassword()"><i class="fas fa-eye"></i></a>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mt-3">
                    <label for="password-confirm" class="text-sm">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="w-full rounded" name="password_confirmation" required autocomplete="new-password" style="padding: 12px 15px;">
                    </div>
                </div>
                <p class="text-xs text-gray-500">Both passwords must match.</p>

                <div class="mt-3">
                    <label for="password-confirm" class="text-sm">{{ __('Language') }}</label>

                    <select name="language" class="w-full rounded">
                      <option value="english">English</option>
                    </select>
                </div>

                <div class="mt-5 mb-0">
                    <div>
                        <button type="submit" class="block w-1/2 mx-auto rounded text-white text-lg font-bold" style="padding: 12px; background:#0ac2c8" >
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
    <div class="w-full bg-red-100 text-center mt-5 py-2">
      <a onclick="$('div#deleteConfirm').fadeIn(200);" class="text-red-700" style="cursor: pointer;">Delete Account</a>
      {{-- <a href="{{route('deleteAccount')}}" class="text-red-700">Delete Account</a> --}}
    </div>
</div>
<script>
    function toggleCurPassword() {
        if($("input#curPassword").attr('type') == 'password') {
            $("input#curPassword").attr('type', 'text');
            $("a#toggleCurPassword i").removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $("input#curPassword").attr('type', 'password');
            $("a#toggleCurPassword i").removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }
    function toggleNewPassword() {
        if($("input#newPassword").attr('type') == 'password') {
            $("input#newPassword").attr('type', 'text');
            $("a#toggleNewPassword i").removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            $("input#newPassword").attr('type', 'password');
            $("a#toggleNewPassword i").removeClass('fa-eye-slash').addClass('fa-eye');
        }
    }
</script>
@endsection
