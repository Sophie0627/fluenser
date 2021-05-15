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

    <!-- Scripts -->
<!--<script src="{{ asset('public/js/app.js') }}" defer></script>-->
    <!-- pusher scripts-->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- bootstarp -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- pusher.js -->
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <!-- croper js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"
          integrity="sha256-jKV9n9bkk/CTP8zbtEtnKaKf+ehRovOYeKoyfthwbC8=" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"
            integrity="sha256-CgvH7sz3tHhkiVKh05kSUgG97YtzYNnWt6OXcmYzqHY=" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/css/all.css') }}">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        input:focus, select:focus, textarea:focus {
            outline: none !important;
        }

        .col-md-8 {
            padding: 0 !important;
        }

        a:hover {
            text-decoration: none;
            cursor: pointer;
        }

        input[type='checkbox']:focus {
            border: none;
        }

        .invalid-feedback {
            color: red;
        }

        a.selected {
            background: white;
            border-radius: 0.25rem;
            color: #999;
        }

        a.unselected {
            color: #999;
        }

        .clearfix {
            display: table;
            content: '';
            clear: both;
        }

        .menu_selected {
            color: black;
            border-bottom: solid 4px rgb(83, 181, 193);
        }

        #mail-component #messageTab a.active,
        #searchTab a.active,
        #collTab a.active {
            border-bottom: solid 2px #4db3c1;
        }

        #searchTab a.active {
            color: #4db3c1;
        }

        a:focus {
            color: black !important;
        }

        #lg_tabMenu a.active {
            color: black;
        }

        #buttons button:hover {
            color: lightgrey;
        }

        #buttons button:disabled:hover {
            color: white;
        }

        .hasImage:hover section {
            background-color: rgba(5, 5, 5, 0.4);
        }

        .hasImage:hover button:hover {
            background: rgba(5, 5, 5, 0.45);
        }

        /* #overlay p, i {
        opacity: 0;
        } */

        #overlay.draggedover {
            background-color: rgba(255, 255, 255, 0.7);
        }

        #overlay.draggedover p,
        #overlay.draggedover i {
            opacity: 1;
        }

        .group:hover .group-hover\:text-blue-800 {
            color: #2b6cb0;
        }

        img#image {
            display: block;
            max-width: 100%;
        }

        .preview {
            overflow: hidden;
            width: 160px;
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }

        .modal-lg {
            max-width: 1000px !important;
        }

        #searchCategory label {
            font-family: 'Poppins', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #bbf3f1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #2bc5b5;
            border-radius: 4px;
        }

        a.payMethod.active div.payMethod {
            background: #52abb1 !important;
            border: none;
        }

        a.payMethod.active div.payMethod p {
            color: white;
        }

        #star-rating a:hover {
            color: rgba(251, 191, 36);
        }

        .carousel-indicators {
            bottom: -40px;
        }

        .carousel-indicators li {
            width: 4px !important;
            height: 4px !important;
            opacity: 1 !important;
            border-radius: 50%;
            border: none;
            margin-bottom: 10px;
            background-color: #0ac0c6;
        }

        .carousel-indicators li.active {
            box-shadow: 0 0 0px 2px #0ac0c677;
        }

        input:focus {
            border: #333 !important;
        }

        th:first-child {
            border-top-left-radius: 10px;
        }

        th:last-child {
            border-top-right-radius: 10px;
        }
    </style>
</head>
<body onunload="arrive()">
<div id="confirmModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-8/12 mx-auto h-26 mt-4">
            <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure project is completed?</p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white"
                        onclick="$('div#confirmModal').hide()">Cancel
                    </button>
                </div>
                <div class="col-span-1">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                        style="background:rgb(88,183,189)" onclick="onReleaseClick('releaseConfirm')">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="giftConfirmModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-8/12 mx-auto h-26 mt-4">
            <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Are you sure project is completed?</p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white"
                        onclick="$('div#giftConfirmModal').hide()">Cancel
                    </button>
                </div>
                <div class="col-span-1">
                    <button
                        class="w-full h-full block mx-auto px-4 py-1 rounded-br-lg text-white font-bold text-md md:text-lg"
                        style="background:rgb(88,183,189)" onclick="onReleaseClick('giftConfirm')">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="uploadModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <img src="{{ asset('img/uploading.gif') }}" alt="uploading" class="w-1/2 mx-auto">
    </div>
</div>

<div id="deleteModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl"
         style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
        <img src="{{ asset('img/deleting.gif') }}" alt="uploading" class="w-1/2 mx-auto">
    </div>
</div>


<div id="reviewModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-68 bg-white absolute rounded-xl"
         style="top:50%; transform:translateY(-50%); left:50%; margin-left:-45.83333%;" id="modalBody">
        <div class="w-10/12 mx-auto h-26 mt-4">
            <p class="text-center text-lg md:text-xl font-bold">Congratulations!</p>
            <p class="text-center text-sm md:text-md text-gray-500 mt-3 mb-3">You have completed your project.<br/><span
                    class="font-bold text-gray-700">PLEASE LEAVE A REVIEW!</span><br/></p>
        </div>
        <div class="w-full h-16" id="confirmBtn">
            <div class="w-full grid grid-cols-2 h-full">
                <div class="col-span-1 h-full">
                    <a class="text-center w-full h-full block mx-auto px-4 rounded-bl-lg text-gray-500 text-md md:text-lg bg-white"
                       href="{{route('home')}}" style="line-height: 60px;">Cancel</a>
                </div>
                <div class="col-span-1">
                    @if (isset($requests))
                        <a class="text-center w-full h-full block mx-auto px-4 rounded-br-lg text-white font-bold text-md md:text-lg"
                           style="background:rgb(88,183,189); line-height:60px;"
                           href="{{route('leaveReview', ['request_id' => $requests->id])}}">Leave a Review</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<div>
    <nav class="shadow-xl">
        <!-- Mobile menu, show/hide based on menu state. -->
        @guest
        @else
            <div class="w-full fixed bottom-0 z-50">
                <div class="bg-white w-full md:max-w-7xl mx-auto object-center" id="mobile-menu">
                    <div class="px-1 py-1 grid grid-cols-5 sm:px-3 w-full border-t-xl"
                         style="border-top: 2px solid lightgrey;">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <a href="{{ route('home') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-home"></i>
                        </a>

                        <a href="{{ route('inbox') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center unread"
                           id="inbox">
                            <i class="far fa-envelope relative">
                                @if (($unread->inbox + $unread->requests) != 0)
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-2 rounded-full text-white text-xs bg-red-500"
                                        id="newInboxNotif"
                                        style="font-weight: 900; display:block">{{ $unread->inbox + $unread->requests }}</div>
                                @else
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-2 rounded-full text-white text-xs bg-red-500"
                                        id="newInboxNotif"
                                        style="font-weight: 900; display:none">{{ $unread->inbox + $unread->requests }}</div>
                                @endif
                            </i>
                        </a>

                        <a href="{{ route('task', ['item'=>'accepted']) }}" id="task"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-link relative">
                                @if ($unread->task != 0)
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-3 text-white text-xs rounded-full bg-red-500"
                                        id="newTaskNotif" style="display: block">{{ $unread->task }}</div>
                                @else
                                    <div
                                        class="absolute w-4 h-4 -top-2 -right-3 text-white text-xs rounded-full bg-red-500"
                                        id="newTaskNotif" style="display: none">{{ $unread->task }}</div>
                                @endif
                            </i>
                        </a>

                        <a href="{{ route('search') }}"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="fas fa-search"></i>
                        </a>

                        <a data-toggle="modal" data-target="#profileModal"
                           class="text-gray-400 text-xl md:text-2xl hover:text-black block py-2 text-center">
                            <i class="far fa-user"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="profileModal">
                <div class="modal-dialog" style="top: 50%; transform:translateY(-50%);">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Profile</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                            <ul class="w-11/12 mx-auto">
                                <li class="my-4"><a href={{ route('profile', ['username' => Auth::user()->username]) }}>
                                <li class="fas fa-user inline-block w-7"></li>
                                View Profile</a></li>
                                <li class="my-4"><a
                                        href={{ route('editProfile', ['username' => Auth::user()->username]) }}>
                                <li class="fas fa-user-edit inline-block w-7"></li>
                                Edit Profile</a></li>
                                <li class="my-4"><a href={{ route('balance') }}>
                                <li class="fas fa-wallet inline-block w-7"></li>
                                Balance</a></li>
                                <li class="my-4"><a href={{ route('referrals') }}>
                                <li class="fas fa-sync-alt inline-block w-7"></li>
                                Referrals</a></li>
                                <li class="my-4"><a href={{ route('saved') }}>
                                <li class="fas fa-heart inline-block w-7"></li>
                                Saved</a></li>
                                <li class="my-4"><a href="{{ route('accountSetting') }}">
                                <li class="fas fa-cog inline-block w-7"></li>
                                Account Settings</a></li>
                            </ul>
                        </div>

                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <form action="{{ route('logout') }}" id="logout-form" method="post">
                                {{ csrf_field() }}
                                <button type="button" onclick="logout()"><i
                                        class="inline-block w-7 fas fa-sign-out-alt"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="loggedIn" class="loggedIn" hidden></div>
        @endguest
    </nav>
    @yield('content')
</div>
<script>
    var qualityCount = 0;
    var comCount = 0;
    var experCount = 0;
    var professCount = 0;
    var againCount = 0;
    var page = {{ $page ?? 0 }};

    $(document).ready(function () {
        var element = $("#mobile-menu a").eq(page - 1);
        console.log("loaded");
        console.log(element);
        element.addClass('menu_selected');
        $("#lg_tabMenu a").eq(page - 1).addClass('active');
        $("#user-menu-content").css('display', 'none');
        $("#user-menu").click(function () {
            var con = $("#user-menu-content").css('display');
            if (con == 'block') $("#user-menu-content").css('display', 'none');
            else $("#user-menu-content").css('display', 'block');
        });
        if (page === 0) checkSession();

        $("#searchTab a").click(function () {
            console.log($(this).attr('href'));
            $("#searchTab a.active").removeClass('active');
            $(this).addClass('active');
            var index = $(this).attr('id');
            $("div.full-view").hide();
            $("div.grid-view").hide();
            $("div." + index).show();
        });
        $("#gallery .delete").click(function () {
            console.log('ok');
            $(this).parent().remove();
        });
        $("a.payMethod").click(function () {
            $("a.payMethod.active").removeClass('active');
            $(this).addClass('active');
            if ($(this).attr('id') == 'gift') {
                $("div#budgetColumn").hide();
                $("select#price").val('');
                $("input#giftInput").val(1);
            } else {
                $("input#giftInput").val('');
                $("div#budgetColumn").show();
            }
        });

        $("#star-rating a").click(function () {

            if ($(this).attr('class').search('text-gray-400')) {
                $(this).removeClass('text-gray-400').addClass('text-yellow-400');
            }

            var count = $(this).attr('class').split('star-')[1][0];
            switch ($(this).parent().attr('id')) {
                case 'Quality':
                    qualityCount = count;
                    break;
                case 'Communication':
                    comCount = count;
                    break;
                case 'Expertise':
                    experCount = count;
                    break;
                case 'Professionalism':
                    professCount = count;
                    break;
                case 'Would':
                    againCount = count;
                    break;
                default:
                    break;
            }

            $(this).prevAll().removeClass('text-gray-400').addClass('text-yellow-400');
            $(this).nextAll().removeClass('text-yellow-400').addClass('text-gray-400');

            console.log(qualityCount, comCount, experCount, professCount, againCount);

            var rating = (parseInt(qualityCount) + parseInt(comCount) + parseInt(experCount) + parseInt(professCount) + parseInt(againCount)) / 5;
            $('input#rating').val(rating);
        });

    });

    function showProfileModal() {
        if ($("div#profileModal").css('display') == 'none') {
            $("div#profileModal").show();
        } else {
            $("div#profileModal").hide();
        }
    }

    Pusher.logToConsole = true;

    var pusher = new Pusher('da7cd3b12e18c9e2e461', {
        cluster: 'eu',
    });
</script>

@guest
@else
    <script>
        $(document).ready(function () {
            const transactionHeight = window.innerHeight - 475;
            $("div#transaction").css('height', transactionHeight + 'px');
            if (page == 2) {
                var unreadInbox = {{ $unread->inbox }};
                var unreadRequest = {{ $unread->requests }};
                console.log(unreadInbox, unreadRequest);
                if (unreadInbox > 0) {
                    $("a#inbox div#inboxNotif").show();
                }
                if (unreadRequest > 0) {
                    $("a#requests div#requestNotif").show();
                }
            }
        });
        var channel = pusher.subscribe('fluenser-channel');
        channel.bind('fluenser-event', function (data) {
            console.log('newRequest');
            if (data.trigger == 'newRequest') {
                console.log(data);
                if (data.request.send_id == "{{ Auth::user()->id}}" || data.request.receive_id == "{{Auth::user()->id}}") {
                    if ($("#newInboxNotif").css('display') == 'block') {
                        var count = $("#newInboxNotif").text();
                        console.log(count);
                        $("#newInboxNotif").text(parseInt(count) + 1);
                    } else {
                        $("#newInboxNotif").text(1);
                        $("#newInboxNotif").show();
                    }

                    if ($("a#requests div#requestNotif").css('display') != 'block') {
                        $("a#requests div#requestNotif").css('display', 'block');
                    }
                }
            }

            if (data.trigger == 'newRequestChat') {
                if (data.requestChat.receive_id == "{{Auth::user()->id}}") {
                    console.log(data);

                    if ($("#newInboxNotif").css('display') == 'block') {
                        var count = $("#newInboxNotif").text();
                        console.log(count);
                        if ($("div#" + data.requestChat.request_id + " p span").css('display') == 'none') {
                            $("#newInboxNotif").text(parseInt(count) + 1);
                        }
                    } else {
                        $("#newInboxNotif").text(1);
                        $("#newInboxNotif").show();
                    }
                    if ($("a#requests div#requestNotif").css('display') != 'block') {
                        $("a#requests div#requestNotif").css('display', 'block');
                    }
                    $("div#" + data.requestChat.request_id + " p span").show();
                }
            }

            if (data.trigger == 'newInboxChat') {
                if (data.inboxInfo.receive_id == "{{Auth::user()->id}}") {
                    console.log(data);

                    if ($("#newInboxNotif").css('display') == 'block') {
                        var count = $("#newInboxNotif").text();
                        console.log(count);
                        if ($("div#" + data.inboxInfo.inbox_id + " p span").css('display') == 'none') {
                            $("#newInboxNotif").text(parseInt(count) + 1);
                        }
                    } else {
                        $("#newInboxNotif").text(1);
                        $("#newInboxNotif").show();
                    }
                    if ($("a#inbox div#inboxNotif").css('display') != 'block') {
                        $("a#inbox div#inboxNotif").css('display', 'block');
                    }
                    $("div#" + data.inboxInfo.inbox_id + " p span").show();
                }
            }

            if (data.trigger == 'newTask') {
                if (data.request.receive_id == "{{Auth::user()->id}}") {
                    console.log(data);
                    if ($("#newTaskNotif").css('display') == 'block') {
                        var count = $("#newTaskNotif").text();
                        console.log(count);
                        $("#newTaskNotif").text(parseInt(count) + 1);
                    } else {
                        $("#newTaskNotif").text(1);
                        $("#newTaskNotif").show();
                    }
                }
            }
        });

        function arrive() {
            const headers = {
                'Accept': 'application/json'
            };
            var api_token = $("meta[name=api-token]").attr('content');
            var url = "{{ url('/') }}/api/userLogOut?api_token=";
            url = url + api_token;
            $.ajax({
                url: url,
                type: "GET",
                headers: headers,
                success: function (res) {
                    console.log(res);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest, textStatus, errorThrown);
                }
            });
        }

        function logout() {
            const headers = {
                'Accept': 'application/json'
            };
            var api_token = $("meta[name=api-token]").attr('content');
            var url = "{{ url('/') }}/api/userLogOut?api_token=";
            url = url + api_token;
            $.ajax({
                url: url,
                type: "GET",
                headers: headers,
                success: function (res) {
                    console.log(res);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest, textStatus, errorThrown);
                }
            });
            $("form#logout-form").submit();

        }

    </script>
@endguest
</body>
</html>
