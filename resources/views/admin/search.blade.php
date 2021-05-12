@extends('layouts.admin')
@section('content')
  <style>
    #searchContent label {
      display: none;
    }

    #searchContent * {
      color: grey;
    }
  </style>
  <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
    <p class="italic text-lg text-white font-bold leading-8 pr-2"
       style="font-family: 'Josefin Sans', sans-serif;">{{ __('Users') }}</p>
  </div>
  <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
    <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('Users') }}</h2>
  </div>
  <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6" id="searchContent">
    <div class="hidden md:block w-full gap-y-2 md:grid md:grid-cols-4 xl:grid-cols-8 md:gap-x-2">
      <div class="col-span-1">
        <div class="w-full px-2">
          <a class="block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-sm"
             style="border-bottom-color: #07c2c8">
            {{__('Influencers')}}
          </a>
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <a class="block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-sm"
             style="border-bottom-color: #07c2c8">
            {{__('Brands')}}
          </a>
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <label for="categories"></label>
          <select name="categories" id="categories" class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
            <option value="">Category</option>
          </select>
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <label for="location"></label>
          <select name="location" id="location" class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
            <option value="">Location</option>
          </select>
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <label for="name"></label>
          <input type="text" name="name" id="name" placeholder="Name"
                 class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <label for="keyword"></label>
          <input type="text" name="keyword" id="keyword" placeholder="Keyword"
                 class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <button class="block w-4/5 py-2 text-white rounded-sm border-none focus:outline-none text-sm"
                  style="background: linear-gradient(to right, #47afbe, #5fe4ce)">Search
          </button>
        </div>
      </div>
      <div class="col-span-1">
        <div class="w-full px-2">
          <label for="perpage"></label>
          <select name="perpage" id="perpage" class="w-full rounded-sm border-gray-300 bg-transparent text-sm">
            <option value="8">8 per page</option>
            <option value="20">20 per page</option>
            <option value="40">40 per page</option>
            <option value="100">100 per page</option>
          </select>
        </div>
      </div>
    </div>

    <div class="md:hidden w-full">
      <div class="w-full px-2 pb-2">
        <label for="categories"></label>
        <select name="categories" id="categories" class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
          <option value="">Category</option>
        </select>
      </div>
      <div class="w-full px-2 pb-2">
        <label for="location"></label>
        <select name="location" id="location" class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
          <option value="">Location</option>
        </select>
      </div>
      <div class="w-full px-2 pb-2">
        <label for="name"></label>
        <input type="text" name="name" id="name" placeholder="Name"
               class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
      </div>
      <div class="w-full px-2 pb-2">
        <label for="keyword"></label>
        <input type="text" name="keyword" id="keyword" placeholder="Keyword"
               class="w-full rounded-sm border-gray-300 bg-transparent text-xs">
      </div>
      <div class="w-full px-2 pb-2">
        <button class="block w-2/5 mx-auto py-2 text-white rounded-sm border-none focus:outline-none text-xs"
                style="background: linear-gradient(to right, #47afbe, #5fe4ce)">Search
        </button>
      </div>
      <div class="w-full border-top border-bottom border-gray-400">
        <div class="w-full grid grid-cols-3 gap-x-2">
          <div class="col-span-1 text-center flex flex-wrap items-center justify-content-center">
            <i class="fas fa-bars" style="color: #07c2c8;"></i>
          </div>
          <div class="col-span-1 text-center flex flex-wrap items-center justify-content-center">
            <i class="fas fa-border-all" style="color: #07c2c8;"></i>
          </div>
          <div class="col-span-1 w-full flex flex-wrap items-center justify-content-center">
              <label for="perpage"></label>
              <select name="perpage" id="perpage" class="w-full rounded-sm border-gray-300 bg-transparent my-1.5 py-0.5 px-1 text-xs">
                <option value="8">10 per page</option>
                <option value="20">20 per page</option>
                <option value="40">40 per page</option>
                <option value="100">100 per page</option>
              </select>
          </div>
        </div>
      </div>
      <div class="w-full grid grid-cols-3">
        <div class="col-span-1">
          <div class="w-full px-2 pb-2">
            <a class="block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-xs"
               style="border-bottom-color: #07c2c8">
              {{__('Influencers')}}
            </a>
          </div>
        </div>
        <div class="col-span-1">
          <div class="w-full px-2 pb-2">
            <a class="block w-full py-2 text-center border-bottom text-decoration-none cursor-pointer text-xs"
               style="border-bottom-color: #07c2c8">
              {{__('Brands')}}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div id="users">
  </div>
  <div class="clearfix"></div>
@endsection
