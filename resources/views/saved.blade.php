@extends('layouts.app')

@section('content')
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <span><a href="{{ route('home') }}" class="text-white"><i class="fas fa-chevron-left"></i></a></span>
    <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('SAVED') }}</span>
  </div>
</header>
<main>
  <div style="margin-top: 20px; padding-bottom:60px;">
    <div class="w-11/12 grid grid-cols-2 md:grid-cols-4 gap-x-3 gap-y-6 mx-auto">
      @if (count($savedInfos) == 0)
      <p class="text-center text-sm md:text-md text-gray-500">No matching influencers.</p>
      @else
      @foreach ($savedInfos as $savedInfo)
      <a href="{{ route('profile', ['username' => $savedInfo->username]) }}" class="block relative">
        <div class="absolute right-2 top-2" style="color: #0f97cd"><i class="fas fa-heart"></i></div>
        <div class="rounded-xl pt-2" style="box-shadow: 0 0 3px 3px #eee">
          <div class="w-11/12 mx-auto relative">
            <div class="w-8/12 mx-auto rounded-full px-1 py-1 mt-3" style="background: linear-gradient(to right, #06ebbe, #1277d3)" >
              <img class="rounded-full w-full" src="{{ url('/storage/profile-image/').'/'.$savedInfo->avatar.'.jpg' }}" alt="$savedInfo->avatar" style="border:solid 2px white">
            </div>
          </div>
          <div class="mt-2">
              <h3 class="text-center text-sm md:text-md font-bold text-gray-700">{{ $savedInfo->name }}</h3>
              <p class="text-center text-xs md:text-sm text-gray-500 mt-1 mb-1">{{ '@'.$savedInfo->username }}</p>
              <p class="text-center text-xs md:text-sm text-gray-700"><i class="fas fa-map-marker-alt" style="color: #119dab"></i> {{ $savedInfo->state.', '.$savedInfo->country }}</p>
          </div>
          <div class="mt-2 w-full">
            <div class="md:text-sm flex justify-center" style="font-size:0.6rem">
              <span class="px-1 bg-yellow-400 rounded text-white mr-1" style="height:17px; line-height:17px;">{{ number_format($savedInfo->rating, 1) }}</span>
              <span style="line-height:17px;">
                @for ($i = 0; $i < 5; $i++)
                  @if ($savedInfo->rating > $i)
                    <i class="fas fa-star text-yellow-400"></i>
                  @else
                    <i class="fas fa-star text-gray-400"></i>
                  @endif
                @endfor
              </span>
              <span class="ml-1 text-gray-700" style="line-height: 17px; font-weight:600;">({{ $savedInfo->reviews }})</span>
            </div>
          </div>
          <div class="mt-2 w-full">
            <div class="flex justify-center" style="font-size: 8px;">
              @if (count($savedInfo->categories) > 0)
              <div class="w-1/3 text-center py-1 rounded mx-1" style="background: #f0f0fd;color:#8c82df;">
                <p>{{ $savedInfo->categories[0]->category_name }}</p>
              </div>
              <div class="w-1/3 text-center py-1 rounded mx-1" style="background: #fcefed;color:#dc8179">
                @if (count($savedInfo->categories) > 1)
                  <p>{{ $savedInfo->categories[1]->category_name }}</p>
                @endif
              </div>
              @else
              <div style="height: 20px;"></div>
              @endif
            </div>
          </div>
          <div class="mt-3 w-10/12 mx-auto" style="border-top: 1px solid lightgray">
            <div class="text-lg md:text-xl text-center flex justify-between pt-1 pb-2">
              <div class="w-1/3 text-center">
                <p><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></p>
                <p class="text-gray-700 tracking-tighter" style="font-size: 10px; line-height:13px;">
                  @switch($savedInfo->profile->instagram_follows)
                      @case(11)
                          1k-10k
                          @break
                      @case(60)
                          10k-50k
                          @break
                      @case(600)
                          100k-500k
                          @break
                      @default
                          unknown
                          @break
                  @endswitch
                </p>
              </div>
              <div class="w-1/3 text-center" style="border-right: 1px solid lightgray; border-left:1px solid lightgray">
                <p><i class="fab fa-youtube text-red-400"></i></p>
                <p class="text-gray-700 tracking-tighter" style="font-size: 10px; line-height:13px;">
                  @switch($savedInfo->profile->youtube_follows)
                      @case(11)
                          1k-10k
                          @break
                      @case(60)
                          10k-50k
                          @break
                      @case(600)
                          100k-500k
                          @break
                      @default
                          unknown
                          @break
                  @endswitch
                </p>
              </div>
              <div class="w-1/3 text-center">
                <p><i class="fab fa-tiktok text-gray-700"></i></p>
                <p class="text-gray-700 tracking-tighter" style="font-size: 10px; line-height:13px;">
                  @switch($savedInfo->profile->tiktok_follows)
                      @case(11)
                          1k-10k
                          @break
                      @case(60)
                          10k-50k
                          @break
                      @case(600)
                          100k-500k
                          @break
                      @default
                          unknown
                          @break
                  @endswitch
                </p>
              </div>
            </div>
          </div>
    </div>
      </a>
      @endforeach
      @endif
    </div>
  </div>
</main>
@endsection
