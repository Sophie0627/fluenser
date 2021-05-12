@extends('layouts.admin')
@section('content')
  <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
    <p class="italic text-lg text-white font-bold leading-8 pr-2" style="font-family: 'Josefin Sans', sans-serif;">{{ __('News Feed') }}</p>
  </div>
  <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
    <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('News Feed') }}</h2>
  </div>
  <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6">
    <div class="max-w-4xl mx-auto">
      <form action="">
        {{ csrf_field() }}
        <div class="w-full bg-gray-100 rounded-xl px-5 py-10">
          <p class="text-lg text-gray-300 font-bold text-center pb-3">Upload Cover Photo</p>
          <button class="text-md rounded-full px-4 py-2 bg-gray-500 text-white block mx-auto">Select photos</button>
        </div>
        <div class="max-w-3xl mx-auto pt-10">
          <div class="grid grid-cols-2 gap-x-4">
            <div class="col-span-1">
              <div class="w-4/5 mx-auto rounded-full bg-white shadow-md px-1 py-1">
                <img src="{{ asset('img/avatar.png') }}" alt="avatar" class="w-full rounded-full">
              </div>
              <button class="mt-5 block mx-auto rounded-sm bg-gray-200 text-gray-500 px-4 py-2">Edit Picture</button>
            </div>
            <div class="col-span-1 relative">
              <div class="absolute w-full" style="transform: translateY(-50%); top: 50%;">
                <label for="full_name" class="font-bold w-full text-gray-500">Name</label>
                <input type="text" name="full_name" id="full_name" class="w-full px-2 py-3 text-gray-500 rounded-sm border-gray-200" placeholder="Enter Full Name">
              </div>
            </div>
          </div>
        </div>
        <div class="w-full mt-5">
          <label for="title" class="text-gray-500 font-bold">Project Title</label>
          <input type="text" name="title" id="title" class="border-gray-200 w-full px-2 py-3" placeholder="Enter Project Title">
        </div>
        <div class="w-full mt-5">
          <label for="description" class="text-gray-500 font-bold">Project Title</label>
          <textarea  type="text" name="description" id="description" class="bg-gray-100 border-none w-full px-2 py-3" placeholder="It is a long established fact..." ></textarea>
        </div>
      </form>
    </div>
    <div class="clearfix"></div>
  </div>
@endsection
