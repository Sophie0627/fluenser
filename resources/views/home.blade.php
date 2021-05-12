@extends('layouts.app')

@section('content')
<script src="https://js.stripe.com/v3/"></script>
<header class="bg-white">
    <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
      <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('HOME') }}</p>
    </div>
    <div class="w-full md:max-w-7xl mx-auto px-2 h-8" style="border-bottom: 1px solid lightgray">
        <span class="mx-4 px-1 pt-2 pb-1 font-bold text-sm md:text-md leading-8" style="border-bottom: 2px solid #4db3c1">{{ __('NEWS FEED') }}</span>
    </div>
    @if ($url != '')
        <div class="w-full md:max-w-7xl mx-auto">
            <a onclick="location.href='{{ $url }}'">
                <div class="w-11/12 mx-auto rounded-xl px-2 py-2 mt-3" style="box-shadow: 0 0 10px 0 #999">
                    <div class="float-left h-12 w-12 px-1 py-1 rounded-full my-2" style="background: #c2c2c2">
                        <img src="{{ asset('img/caution.png') }}" alt="caution" class="w-full">
                    </div>
                    <div class="float-right py-2 px-1 my-2">
                        <i class="fas fa-chevron-right text-gray-500" style="line-height: 1.75rem"></i>
                    </div>
                    <p class="text-sm md:text-md font-bold pl-14">Connect to Stripe</p>
                    <p class="text-gray-500 text-xs md:text-sm tracking-tighter pl-14">We've partnered with stripe for fast, secure payments. Fill out a few more details to complete your profile and start getting paid.</p>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    @endif
  </header>

	<main class="w-full md:max-w-7xl mx-auto pb-20">
		<!--@foreach ($portfolios as $portfolio)-->
		<!--		<div class="w-11/12 mx-auto rounded-xl mt-3 pb-3" style="box-shadow: 0 0 10px 0 #999">-->
		<!--			<img class="w-full rounded-t-xl" src="{{ url('/storage/profile-image/'.$portfolio->slide_img.'.jpg') }}" alt={{ $portfolio->slide_img }}>-->
		<!--			<div class="w-full rounded-b-xl mt-3">-->
		<!--				<p class="text-md md:text-lg font-bold pl-3">There are many variations of passages</p>-->
		<!--				<div class="mt-2 w-11/12 mx-auto">-->
		<!--					<div class="float-left w-14 h-14">-->
		<!--						<img class="w-full rounded-full" src="{{ url('/storage/profile-image/'.$accountInfo->avatar.'.jpg') }}" alt={{ $accountInfo->avatar }}>-->
		<!--					</div>-->
		<!--					<div class="float-left h-14 py-1 pl-3">-->
		<!--						<p class="text-sm:md:text-md leading-6 font-bold">{{ $accountInfo->name }}</p>-->
		<!--						<p class="text-xs:md:text-sm leading-6">{{ '@'.$accountInfo->username }}</p>-->
		<!--					</div>-->
		<!--					<div class="clearfix"></div>-->
		<!--				</div>-->
		<!--			</div>-->
		<!--		</div>-->
		<!--@endforeach-->
	</main>
@endsection
