@extends('layouts.app')

@section('content')
<header class="bg-white">
    <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
      <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('DASHBOARD') }}</p>
    </div>
  </header>

    <main class="w-full md:max-w-7xl mx-auto">
        <!-- Replace with your content -->
        <div class="w-11/12 sm:px-0 bg-white mx-auto mt-4">
            <div class="w-full">
                <div class="w-full mx-auto relative py-3 rounded-xl" style="background: #f4fdfd; box-shadow: 0 0 3px #999">
                    <div class="w-4/12 inline-block align-middle">
                        <img class="rounded-full w-11/12 float-right" src="{{ url('/storage/profile-image/').'/'.$accountInfo->avatar.'.jpg' }}" alt="$accountInfo->avatar" style="border:solid 3px white;box-shadow: 0 2px 1px 1px lightgrey">
                        <div class="clearfix"></div>
                    </div>
                    <div class="inline-block w-7/12 pl-1 text-center align-middle">
                        <h1 class="font-bold text-lg md:text-2xl">{{ $accountInfo->name }}</h1>
                        <div class="w-full mx-auto rounded-full bg-white px-2 py-1 text-xs  text-left md:text-sm mt-4 relative h-8 md:h-10" style="box-shadow: 0 0 10px 0 #333">
                            <p class="leading-6 md:leading-8">Fluenser.com/{{ $accountInfo->username }}</p>
                            <button class="block absolute bottom-0 right-1 px-2 h-6 my-1 py-1 rounded-full bg-gray-700 text-white leading-4 md:h-8 md:leading-6">Claim</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="w-full mt-4">
                <div class="grid grid-rows-3 gap-y-2">
                    <div class="row-span-1">
                        <div class="grid grid-cols-3 gap-x-2">
                            <div class="col-span-1">
                                <a href={{ route('profile', ['username' => $accountInfo->username]) }} class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/user.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">My profile</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href={{ route('editProfile', ['username' => $accountInfo->username]) }} class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/user-edit.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Edit  profile</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href={{ route('inbox') }} class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/inbox.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Inbox</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row-span-1">
                        <div class="grid grid-cols-3 gap-x-2">
                            <div class="col-span-1">
                                <a href={{ route("balance") }} class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/balance.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Balance</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href="#" class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/statement.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Statement</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href="#" class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/referrals.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Referrals</p>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="row-span-1">
                        <div class="grid grid-cols-3 gap-x-2">
                            <div class="col-span-1">
                                <a href="#" class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/reviews.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Reviews</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href="#" class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/saved.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Saved</p>
                                </a>
                            </div>
                            <div class="col-span-1">
                                <a href="#" class="block w-full py-7 md:py-9 text-center text-gray-500" style="border-radius: 0 10px; box-shadow:0 0 10px #999;">
                                    <img src="{{ asset('img/setting.png') }}" alt="" class="w-8 mx-auto">
                                    <p class="text-sm md:text-md mt-1">Account Setting</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <form action="{{ route('logout') }}" id="logout-form" method="post">
                    @csrf
                    <button type="submit">{{ __('Logout') }}</button>
                </form>
            </div>
        </div>
    </main>
@endsection
