@extends('layouts.app')
@section('content')
<style type="text/css">
  a.inactive {
    pointer-events: none;
    background: gray !important;
  }
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<main>
  <div id="modal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 h-48 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
      <div class="w-8/12 mx-auto h-26 mt-4">
        <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5">Would you like to request a collaboration with <span class="text-lg font-bold">{{ $accountInfo->name }}</span>?</p>
      </div>
      <div class="w-full h-16" id="confirmBtn">
        <div class="w-full grid grid-cols-2 h-full">
          <div class="col-span-1 h-full">
            <button class="w-full h-full block mx-auto px-4 py-1 rounded-bl-lg text-gray-500  text-md md:text-lg bg-white" onclick="$('div#modal').hide()">Cancel</button>
          </div>
          <div class="col-span-1">
            <a class="w-full h-full block mx-auto px-4 py-1 text-center rounded-br-lg text-white font-bold text-md md:text-lg" style="background:rgb(88,183,189); line-height:64px;" onclick="sendRequest()">Yes</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="successAlert" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <div class="w-11/12 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
      <div class="w-8/12 mx-auto mt-4">
        <p class="text-center text-md md:text-lg text-gray-700 mt-5 mb-5 py-3">Request Sent</p>
      </div>
    </div>
  </div>

  <div class="w-full md:max-w-7xl mx-auto mb-12">
    <!-- Replace with your content -->
      <div class="bg-white">
        <div class="w-full relative">
          <div class="relative">
            <a href={{ route('home') }}>
              <div class="absolute top-4 left-2 rounded-full h-8 w-8 bg-white text-center" style="box-shadow: 0 0 15px #999">
                <p class="leading-8 text-gray-400 text-lg">
                  <i class="fas fa-arrow-left"></i>
                </p>
              </div>
            </a>
            <a onclick="toggleSaved()">
              <div class="absolute top-4 right-2 rounded-full h-8 w-8 bg-white text-center" style="box-shadow: 0 0 15px #999">
                @if ($saved)
                  <p class="leading-8 text-gray-400" style="color: #0f97cd" id="saved">
                    <i class="fas fa-heart"></i>
                  </p>
                @else
                  <p class="leading-8 text-gray-400 text-lg" id="saved">
                    <i class="fas fa-heart"></i>
                  </p>
                @endif
              </div>
            </a>
            <img src={{ url('/storage/profile-image/'.$profile->top_img.'.jpg') }} alt={{ $profile->top_img }} class="w-full">
            <div class="w-10/12 absolute px-2 pb-2 bottom-5 bg-white h-36 md:h-40" style="left: 50%; margin-left: -41%; bottom:60px">
              <div class="relative ml-2 h-8">
                <div class="absolute" style="width: 33%;bottom:0;">
                  <img src={{ url('/storage/profile-image/'.$profile->round_img.'.jpg') }} alt={{ $profile->round_img }} class="rounded-full" style="border:3px solid white">
                </div>
                @if($accountInfo->loggedIn)
                <div style="margin-left: 30%;" class="h-full text-green-500">
                  <span><i class="fas fa-circle" style="font-size: 5px; line-height:2rem;"></i></span>
                  <span class="leading-8 text-xs md:text-sm text-gray-500" style="line-height: 2rem;font-family: 'Poppins', sans-serif; font-weight: 500;">
                    Active now
                  </span>
                </div>
                @else
                <div style="margin-left: 30%;" class="h-full text-gray-500">
                  <span><i class="fas fa-circle" style="font-size: 5px; line-height:2rem;"></i></span>
                  <span class="leading-8 text-xs md:text-sm" style="line-height: 2rem;" style="font-family: 'Poppins', sans-serif; font-weight: 500;">
                    last seen {{ $accountInfo->interval }} ago
                  </span>
                </div>
                @endif
              </div>
              <div class="relative ml-2">
                <div class="float-left w-9/12" style="font-family: 'Poppins', sans-serif;">
                  <p class="text-md md:text-lg font-bold" style="font-weight:600">{{ $accountInfo->name }}</p>
                  <p class="text-xs md:text-sm text-gray-700" style="font-weight: 400;">{{ '@'.$accountInfo->username }}</p>
                  <div class="text-sm md:text-md">
                    <span class="px-1 rounded text-white font-bold rounded-lg mr-1 text-xs md:text-sm" style="padding: 1px 3px; line-height:20px; background:#f5a321;">{{ number_format($accountInfo->rating, 1) }}</span>
                    <span style="line-height:26px;">
                      @for ($i = 0; $i < 5 ; $i++)
                        @if ($accountInfo->rating > $i)
                          <i class="fas fa-star" style="color: #f5a321"></i>
                        @else
                          <i class="fas fa-star text-gray-400"></i>
                        @endif
                      @endfor
                    </span>
                  <span class="ml-1 text-gray-700" style="line-height: 20px;">({{ ($accountInfo->reviews != 0) ? $accountInfo->reviews : __("") }})</span>
                  </div>
                  <p class="text-sm md:text-md text-gray-700 mt-1" style="font-weight: 400;"><i style="color: #119dab" class="fas fa-map-marker-alt"></i> {{ $accountInfo->state.', '.$accountInfo->country }}</p>
                </div>
                <div class="float-right w-3/12 pr-2 pt-3" style="font-family: 'Poppins', sans-serif;">
                  @if(count($categories) > 0)
                  <div class="mb-2 px-1 py-1 rounded-lg w-full" style="background:#{{ $categories[0]->back_color }}">
                    <p class="text-sm text-center" style="color: {{ __("#") . $categories[0]->text_color }}; font-weight:500;">{{ $categories[0]->category_name }}</p>
                  </div>
                @endif
                    @if(count($categories) > 1)
                  <div class="mb-2 px-1 py-1 rounded-lg w-full" style="background: {{__("#") . $categories[1]->back_color }}">
                    <p class="text-sm text-center" style="color: {{__("#") . $categories[1]->text_color }}; font-weight:500;">{{ $categories[1]->category_name }}</p>
                  </div>
                  @endif
                </div>
                <div id="social_links" class="w-3/5 float-right">
                  <div class="w-10 h-10 rounded-full float-right mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                    <a href="{{ 'https://'.$profile->tiktok }}" class="text-center leading-10"><i class="fab fa-tiktok"></i></a>
                  </div>
                  <div class="w-10 h-10 rounded-full float-right mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                    <a href="{{ 'https://'.$profile->youtube }}" class="text-center leading-10 text-red-700"><i class="fab fa-youtube"></i></a>
                  </div>
                  <div class="w-10 h-10 rounded-full float-right mx-1 bg-white text-center" style="box-shadow: 0 0  8px 0 #999">
                    <a href="{{ 'https://'.$profile->instagram }}" class="text-center leading-10"><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
          <div class="h-8 rounded-t-2xl bg-white w-full absolute -bottom-1"></div>
        </div>
        <div class="w-full pt-2 pb-8">
          <div class="w-11/12 mx-auto rounded-lg bg-gray-200" style="font-family: 'Poppins', sans-serif; font-weight: 600; ">
            <div class="w-full grid grid-cols-2">
              <div class="col-span-1 px-1 py-1">
                <button class="tablink py-1 rounded-lg w-full text-gray-500 font-bold" onclick="openTab('profile', this)" id="defaultOpen">Profile</button>
              </div>
              <div class="col-span-1 px-1 py-1">
                <button class="tablink py-1 rounded-lg w-full text-gray-500 font-bold" onclick="openTab('reviews', this)">Reviews</button>
              </div>
            </div>
          </div>
          <div id="profile" class="tabcontent w-full mx-auto">
            <div id="introduction" class="w-11/12 mx-auto my-2 py-3">
              <p class="text-md md:text-lg">
                {{ $profile->introduction }}
              </p>
            </div>
            <div id="portfolio" class="py-8 w-full mx-auto bg-gray-100" style="border-top: 1px solid lightgray; border-bottom: 1px solid lightgray">
              @if (count($portfolios) > 0)
              <div id="portfolio-slide" class="w-full overflow-hidden relative">
                <div style="width: 150%;">
                  <div class="swiper-container w-full h-full">
                    <div class="swiper-wrapper" style="padding-left: 30px;">
                      @foreach ($portfolios as $item)
                          <div class="swiper-slide overflow-hidden rounded-xl" onload="resize()">
                            <img src="{{ url('/storage/profile-image/' . $item->slide_img . '.jpg') }}" alt="{{ $item->slide_img }}" style="width: 100%;" class="relative">
                          </div>
                      @endforeach
                      <div class="swiper-slide"></div>
                    </div>
                  </div>
                </div>
              </div>
              @else
              <div class="w-full my-2 text-center">
                Please complete your profile.
              </div>
              @endif
            </div>

          @if ($accountInfo->accountType == 'influencer')
            <div id="partnership" class="w-11/12 mx-auto" style=" padding-bottom: 50px !important;">
              <p class="text-center text-gray-400 py-2 mt-3 text-md md:text-lg tracking-wide" style="font-family: 'Poppins', sans-serif; font-weight:500;">
                INFLUENCER PARTNERSHIPS
              </p>
              <div id="partnership_slide">
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
                    <div class="carousel-inner">
                      @if(count($partnerships) > 0)
                      <div class="carousel-item active">
                        <img class="w-9/12 mx-auto rounded-xl" src={{ url('/storage/partnership-image/'.$partnerships[0]->partnership_img).'.jpg' }} alt={{ $partnerships[0]->partnership_img }} >
                      </div>
                      @for ($i = 1; $i < count($partnerships); $i++)
                      <div class="carousel-item">
                        <img class="w-9/12 mx-auto rounded-xl" src={{ url('/storage/partnership-image/'.$partnerships[$i]->partnership_img).'.jpg' }} alt={{ $partnerships[$i]->partnership_img }}>
                      </div>
                      @endfor
                      @else
                      <div class="text-center w-full">
                        <p class="text-sm md:text-md">Please complete you profile</p>
                      </div>
                      @endif

                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endif

        </div>
          <div id="reviews" class="tabcontent w-11/12 mx-auto pb-10">
            <div id="reviews" class="w-11/12 mx-auto my-8">
              @if (count($reviews) == 0)
                <p class="text-center text-md md:text-lg">
                  No review.
                </p>
              @else
                @foreach ($reviews as $review)
                  <div class="title my-2">
                    <p class="text-lg md:text-xl font-semibold">
                      {{ $review->title }}
                    </p>
                  </div>
                  <div class="rating my-2">
                    <span class="px-2 py-1 bg-yellow-400 rounded-md text-white text-xs md:text-sm font-bold">{{ number_format($review->star, 1) }}</span>
                    @for ($i = 0; $i < 5; $i++)
                      @if ($review->star > $i)
                        <i class="fas fa-star text-yellow-400"></i>
                      @else
                        <i class="fas fa-star text-gray-400"></i>
                      @endif
                    @endfor
                  </div>
                  <div class="review my-2">
                    <p class="text-sm md:text-md">{{ $review->review }}</p>
                  </div>
                  <div class="com my-2">
                    @if (count(explode('-', $review->interval)) > 0)
                    <p class="text-xs md:text-sm text-gray-500">by {{ $review->name }} - {{ $review->interval }}</p>
                    @else
                    <p class="text-xs md:text-sm text-gray-500">by {{ $review->name }} - {{ $review->interval }} ago</p>
                    @endif
                  </div>
                  <hr class="mt-3">
                @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full fixed bottom-0 z-50 bg-white">
      <div class="w-full md:max-w-7xl mx-auto py-3" style="border-top: 1px solid lightgray">
        <div class="w-8/12 mx-auto">
            @if ($accountInfo->id == Auth::user()->id)
                <a href="{{ route('editProfile', ['username' => Auth::user()->username]) }}" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Edit</a>
            @else
                @if ($accountInfo->accountType == 'influencer')
                <a href="{{ route('collaborate', ['user_id' => $accountInfo->id]) }}" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Collaborate</a>
                @else
                <a onclick="$('div#modal').show();" class="focus:text-gray-300 block w-full py-2 text-center text-white font-bold text-lg md:text-xl rounded-lg" id="sendRequest" style="background: #0ac2c8; font-family:'Poppins', sans-serif; font-weight:500;">Request</a>
                @endif
            @endif
        </div>
      </div>
    </div>
</main>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 2,
    spaceBetween: 35,
    freeMode: true,
  });
  function openTab(tabname, elmnt) {
  var width = $("div.swiper-slide").css('width');
  console.log(width);
  if(width != undefined) {
      width = width.slice(0, -2);
      console.log(width);
      height = parseInt(width) * 1.1;
      console.log(height);
      $("div.swiper-slide").css('height', height + 'px');
    }
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Remove the background color of all tablinks/buttons
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }

  // Show the specific tab content
  document.getElementById(tabname).style.display = "block";

  // Add the specific color to the button used to open the tab content
  elmnt.style.backgroundColor = 'white';
  }

    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();


  function toggleSaved() {
    const headers ={
        'Accept': 'application/json'
      };
      var api_token = $("meta[name=api-token]").attr('content');
      var url = "{{ url('/') }}/api/savedToggle/{{$accountInfo->id}}?api_token=";
      url = url + api_token;
      console.log(url);
      $.ajax({
        url: url,
        type: "GET",
        headers: headers,
        success: function(res) {
          if(res.data == 1) {
            $("p#saved").css('color', '#0f97cd');
          } else {
            $("p#saved").css('color', 'rgb(156, 163, 175)')
          }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          console.log(XMLHttpRequest, textStatus, errorThrown);
        }
      });
  }

  function sendRequest() {
    const api_token = $("meta[name=api-token]").attr('content');
    const url = '{{ url("/") }}/api/influencerRequest/{{ $accountInfo->id }}?api_token=' + api_token;
    $.ajax({
      url: url,
      type:'get',
      success: function(res) {
        console.log('success');
        $("div#modal").hide();
        $("div#successAlert").fadeIn(200).delay(2000).fadeOut(200);
        $("a#sendRequest").addClass('inactive');
        $("a#sendRequest").text('Requested');
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        console.log(XMLHttpRequest, textStatus, errorThrown);
      },
    });
  }

</script>
@endsection
