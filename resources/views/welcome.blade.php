<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fluenser</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;600&family=Poppins:wght@400;500;600&family=Ubuntu&display=swap" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/css/all.css') }}">

<style>
        .active,
        .dot:hover {
            background-color: #717171;
        }

        #wel_btn {
            width: 200px;
            position: absolute;
            bottom: 150px;
            left: 50vw;
            margin-left: -100px;
        }

        #hire_btn {
            border: none;
            border-radius: 10px;
            background: linear-gradient(to right, RGB(5, 235, 189), RGB(19, 120, 212));
        }

        #join_btn {
            border: solid 1px white;
            background: transparent;
        }

        #back_img {
            position: relative;
        }

        #avatar_img {
            position: absolute;
        }

        .clearfix {
            display: table;
            content: '';
            clear: both;
        }

        div#main_btn a:hover,
        div#main_btn a:active,
        div#main_btn a:visited,
            {
            background: none;
        }
        #how-it-works #gradient-icon i {
            background: -moz-linear-gradient(to right, RGB(5,235,189), RGB(19,120,212));
            background: -webkit-linear-gradient(to right, RGB(5,235,189), RGB(19,120,212));
            background: linear-gradient(to right, RGB(5,235,189), RGB(19,120,212));
            -webkit-background-clip: text;
            -moz-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 20px;
        }
        #how-it-works #gradient-icon {
            text-align: center;
            width:40px;
            height:40px;
            padding:7px;
            top: 50%;
            transform: translateY(-50%);
            left: 5px;
            border: 1px solid gray;
        }
        .clearfix {
            display: table;
            content: '';
            clear: both;
        }

        #featured_img {
            position: absolute;
            top: 0;
            right: -50%;
        }
        .carousel-indicators li{
            width: 5px !important;
            height: 5px !important;
            opacity: 1 !important;
            border-radius: 50%;
            border: none;
            margin-bottom: 5px;
            background: #119dab;
        }
        .carousel-indicators {
            margin-bottom: 0;
            line-height: 1;
        }
        .carousel-indicators li.active {
            box-shadow: 0 0 0px 2px #95c3c7;
        }
    </style>
</head>

<body class="antialiased">
    <div>
        <nav class="bg-white">
            <div class="max-w-7xl mx-auto px-2" style="border-bottom: 1px solid lightgray;">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <a href="{{route('welcome')}}">
                                <img class="h-10" src="{{ asset('img/logo.jpg') }}" alt="Workflow">
                            </a>
                        </div>
                    </div>
                    <div class="md:block">
                        <div class="ml-4 flex items-center md:ml-6" id="main_btn">
                            @if (Route::has('login'))
                            @auth
                            <a href="{{ url('/home') }}"
                                class="text-gray-300 hover:text-indigo-700 rounded-md text-xs md:text-sm font-medium mr-2">{{__('Home')}}</a>
                            @else
                            <a href="{{ route('login') }}"
                                class="text-gray-500 rounded-md text-sm font-medium tracking-wider hover:text-indigo-700 mr-4">{{__('Log In')}}</a>

                            @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-gray-500 rounded-md text-sm font-medium hover:text-indigo-700 tracking-wider mr-2">{{__('Sign Up')}}</a>
                            @endif
                            @endauth
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4">
                <p class="text-2xl font-bold text-center mt-8" style="font-family: 'Poppins', sans-serif; font-weight:600;">The home of influencers</p>
                <p class="text-md" style="font-family: 'Ubuntu', sans-serif;">Collaborate with influencers directly to promote your brand.</p>
                <div class="full grid grid-cols-2 gap-x-3 mt-6" style="font-family: 'Poppins', sans-serif; font-weight:500;">
                    <div class="px-1 py-1">
                        <a class="block text-center py-2 w-full rounded-md text-sm md:text-md text-white" href="{{ route('register') }}" onclick="sessionStorage.setItem('type', 'brand');" style="background: #0ac2c8">Hire an Influencer</a>
                    </div>
                    <div class="px-1 py-1">
                        <a class="block text-center py-2 w-full rounded-md text-sm md:text-md" href="{{ route('register') }}" style="border: 1px solid gray; color:#0ac2c8">Join as Influencer</a>
                    </div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto mt-5 relative" style="margin-bottom: 15vw;">
              <img src="{{ asset('img/homeTop.png') }}" alt="home top image" class="w-full">
              <div class="absolute text-white w-full text-center" style="font-family: 'Josefin Sans', sans serif; transform:translateY(-75%);">
                <p class="text-2xl" style="font-weight: 300; margin-bottom:0;">Influencer</p>
                <p class="text-3xl" style="font-weight: 600; margin-bottom:0;">Partnerships</p>
                <div class="w-2/3 mx-auto mt-3">

                  <!-- Partnership slides -->
                  <div id="partnership" class="w-full mx-auto pb-3">
                    <div id="partnership_slide" class="py-1 px-1 rounded-xl bg-white" style="box-shadow: 0 0 3px 3px lightgray">
                      <div class="w-full mx-auto">
                        <div id="partnerships" class="carousel slide rounded-xl relative z-10" data-ride="carousel">
                          <!-- Indicators -->
                          <ul class="carousel-indicators">
                            <li data-target="#partnerships" data-slide-to="0" class="active"></li>
                            @for ($i = 1; $i < count($partnerships); $i++)
                              <li data-target="#partnerships" data-slide-to={{ $i + 1 }}></li>
                            @endfor
                          </ul>
                          <!-- The slideshow -->
                          @if(count($partnerships) > 0)
                          <div class="carousel-inner rounded-xl">
                            <div class="carousel-item active rounded-xl">
                              <img src={{ url('/storage/partnership-image/'.$partnerships[0]->partnership_img).'.jpg' }} alt={{ $partnerships[0]->partnership_img }} class="w-full rounded-xl">
                            </div>

                            @for ($i = 1; $i < count($partnerships); $i++)
                            <div class="carousel-item">
                              <img src={{ url('/storage/partnership-image/'.$partnerships[$i]->partnership_img).'.jpg' }} alt={{ $partnerships[$i]->partnership_img }} class="w-full rounded-xl">
                            </div>
                            @endfor
                          </div>
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <img src="{{ asset('img/phone.png') }}" alt="phone" class="w-full">
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-3">
                <p class="text-2xl text-center" style="font-family: 'Josefin Sans', sans serif;">
                    <span style="font-weight: 600;">How</span>
                    <span style="font-weight: 300;">it</span>
                    <span style="font-weight: 600;">Works</span>
                </p>
                <p class="text-sm text-center mx-2" style="font-family: 'Poppins', sans-serif; font-weight:400">With secure payments and thousands of reviewed  influencers to choose from, Fluenser is the simplest and safest way to collaborate with influencers online.</p>

                <div class="w-full rounded-lg px-2 py-3 relative mt-3" style="box-shadow: 0 0 3px 3px #eee;" id="how-it-works">
                    <div class="text-gray-500" style="margin-left: 45px;font-size:13px;">Sign up, no hidden costs and completely free to user.</div>
                    <div class="absolute rounded-full" id="gradient-icon"><i class="fas fa-sign-in-alt"></i></div>
                </div>

                <div class="w-full rounded-lg px-2 py-3 relative mt-3" style="box-shadow: 0 0 3px 3px #eee;" id="how-it-works">
                    <div class="text-gray-500" style="margin-left: 45px;font-size:13px;">Discover thousands of verified
                        influencers.</div>
                    <div class="absolute rounded-full" id="gradient-icon"><i class="fas fa-check"></i></div>
                </div>

                <div class="w-full rounded-lg px-2 py-3 relative mt-3" style="box-shadow: 0 0 3px 3px #eee;" id="how-it-works">
                    <div class="text-gray-500" style="margin-left: 45px;font-size:13px;">Directly message influencers with
                        your proposal wether it`s gifted or paid promotion.</div>
                    <div class="absolute rounded-full" id="gradient-icon"><i class="fas fa-comments"></i></div>
                </div>

                <div class="w-full rounded-lg px-2 py-3 relative mt-3" style="box-shadow: 0 0 3px 3px #eee;" id="how-it-works">
                    <div class="text-gray-500" style="margin-left: 45px;font-size:13px;">Your money is held securely by us
                        until you approve the influencers work.</div>
                    <div class="absolute rounded-full" id="gradient-icon"><i class="fas fa-dollar-sign"></i></div>
                </div>

                <div class="w-full rounded-lg px-2 py-3 relative mt-3" style="box-shadow: 0 0 3px 3px #eee;" id="how-it-works">
                    <div class="text-gray-500" style="margin-left: 45px;font-size:13px;">Collaborate completed, time to
                        leave a review!</div>
                    <div class="absolute rounded-full" id="gradient-icon"><i class="fas fa-star"></i></div>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
                <div class="text-center w-full" style="font-family: 'Josefin sans', sans-serif">
                    <p class="text-xl" style="font-weight: 300;margin-bottom:0;">Featured</p>
                    <p class="text-3xl" style="font-weight: 600">Influencers</p>
                </div>
                <!-- Featured influencers slide -->
                <div id="featured_slide" class="w-full relative overflow-hidden">
                    @if(count($featuredInfluencers) > 0)
                    <div style="width: 50%; visibility: hidden; padding:10px;">
                        <div class="card">
                            <img src="{{url('/storage/profile-image/'.$featuredInfluencers[0]->top_img.'.jpg')}}" alt="hidden image" style="width: 100%;">
                            <p class="text-sm my-2">Location here.</p>
                        </div>
                    </div>
                    @endif
                    <div id="featured_img" style="width: 200%;" class="px-1 py-1">
                        @foreach ($featuredInfluencers as $influencer)
                            <a class="w-3/12 float-left px-2" href="{{ route('profile', ['username' => $influencer->username]) }}">
                                <div class="rounded-2xl px-1 py-1 " style="box-shadow: 0 0 3px 3px #ccc">
                                    <div class="relative">
                                        <img src="{{url('/storage/profile-image/'.$influencer->top_img.'.jpg')}}" alt="hidden image" style="width: 100%;" class="rounded-t-2xl">
                                        <div class="bg-black bg-opacity-80 absolute bottom-0 w-full px-1 py-1">
                                            <p class="mb-0 text-xs text-white font-semibold">{{ strtoupper($influencer->name) }}</p>
                                            <p class="mb-0" style="font-size: 9px; color:#0ac2c8">{{ '@'.$influencer->username }}
                                                <span class="float-right">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < $influencer->rating)
                                                            <i class="fas fa-star" style="color: #ffcd33"></i>
                                                        @else
                                                            <i class="fas fa-star" style="color:white"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <p class="text-sm my-2 text-center"><i class="fas fa-map-marker-alt" style="color: #0ac2c8"></i><span style="font-size: 11px"> {{ $influencer->state.', '.$influencer->country }}</span></p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="w-full bg-gray-900 mt-3 pt-8 pb-1">
                <div class="w-11/12 mx-auto text-center">
                    <p class="text-white text-sm">
                        <a href="" class="text-white">Terms & Agreement</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        <a href="" class="text-white">Privacy</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        <a href="" class="text-white">Contact Us</a>
                    </p>
                    <div class="flex justify-center">
                        <a href="" class="block px-2 py-1 mx-2 w-8 h-8 rounded-full bg-gray-500">
                            <i class="fab fa-twitter text-white"></i>
                        </a >
                        <a href="" class="block px-2 py-1 mx-2 w-8 h-8 rounded-full bg-gray-500">
                            <i class="fab fa-instagram text-white"></i>
                        </a >
                        <a href="" class="block px-2 py-1 mx-2 w-8 h-8 rounded-full bg-gray-500">
                            <i class="fab fa-tiktok text-white"></i>
                        </a >
                        <a href="" class="block px-2 py-1 mx-2 w-8 h-8 rounded-full bg-gray-500">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                    <hr class="my-3 bg-white">
                    <p class="text-center text-white text-sm">&copy; 2021 Fluenser</p>
                </div>
            </div>
        </nav>
    </div>
</body>
<script>
    var firstPos, interval;
    $(document).ready(function () {
        firstPos = $("div#featured_img").css('right').slice(0, -2);
        interval = setInterval(slideMove, 20);
    });

    function slideMove() {
        var pos = $("div#featured_img").css('right').slice(0, -2);
        if (pos == 0) {
            var element = $("#featured_img").children()[0];
            $("#featured_img").children()[0].remove();
            $("#featured_img").append(element);
            pos = firstPos;
        }
        $("div#featured_img").css('right', parseInt(pos) + 1);
    }
</script>

</html>
