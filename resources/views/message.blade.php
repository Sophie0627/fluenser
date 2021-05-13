@extends('layouts.app')
@section('content')
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('MESSAGES') }}</p>
  </div>
</header>
  <main class="md:max-w-7xl mx-auto">
    <div class="w-full">
      <!-- Replace with your content -->
        <div class="sm:px-0 bg-white">
          <div id="mail-component"></div>
        </div>
        <div id="item" style="display:none">{{ isset($item) ? $item : '' }}</div>
        <div id="request_id" style="display:none">{{ isset($request_id) ? $request_id : '' }}</div>
    </div>
  </main>
  <script src="{{ asset('public/js/app.js') }}" ></script>
@endsection
