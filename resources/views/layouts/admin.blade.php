<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @guest
  @else
    <meta name="api-token" content="{{ Auth::user()->api_token }}">
  @endguest

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- bootstarp -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/css/all.css') }}">
  <link rel="stylesheet" href="{{ asset('css/css/circle.css') }}">
  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }
    #mobile-menu li a.active,
    #desktop-menu li a.active {
      background-color: #334662;
    }
  </style>
</head>
<body class="bg-gray-50">
  <div class="md:hidden">
    <div class="w-full bg-white relative">
      <img class="h-10 mx-auto mt-1" src="{{ asset('img/logo.jpg') }}" alt="site_logo">
      <a class="absolute bottom-1 left-2 text-2xl" onclick="$('div#mobile-menu').toggle()">
        <i class="fas fa-bars"></i>
      </a>
      <div id="mobile-menu" class="absolute top-10 w-full text-white text-md hidden" style="background-color: #1f2f46">
        <ul class="list-none">
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300 active" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-home"></i> Home</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('news') }}"><i class="w-10 mx-auto fas fa-clipboard-list"></i> News feed</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('users') }}"><i class="w-10 mx-auto fas fa-user"></i> Users</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('projects') }}"><i class="w-10 mx-auto fas fa-file-alt"></i> Projects</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-star"></i> Referrals</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-plus-circle"></i> Extras</a></li>
          <li><a class="block border-top border-gray-700 text-decoration-none py-2 px-8 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="hidden md:block float-left md:w-1/4 lg:w-1/5 xl:w-1/6" style="background-color: #1f2f46; height: 100vh;">
    <div class="w-full bg-white">
      <img class="h-16 mx-auto px-1" src="{{ asset('img/logo.jpg') }}" alt="site_logo">
    </div>
    <div id="desktop-menu" class="w-full text-white text-md">
      <ul class="list-none">
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300 active" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-home"></i> Home</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('news') }}"><i class="w-10 mx-auto fas fa-clipboard-list"></i> News feed</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('users') }}"><i class="w-10 mx-auto fas fa-user"></i> Users</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('projects') }}"><i class="w-10 mx-auto fas fa-file-alt"></i> Projects</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-star"></i> Referrals</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-plus-circle"></i> Extras</a></li>
        <li><a class="block border-t border-gray-600 text-decoration-none py-2 px-6 hover:text-gray-300" href="{{ route('adminDashboard') }}"><i class="w-10 mx-auto fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </div>
  @yield('content')
</body>
</html>
