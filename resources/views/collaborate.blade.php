@extends('layouts.app')
@section('content')
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <span><a href="{{ route('search') }}" class="text-white"><i class="fas fa-chevron-left"></i></a></span>
    <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('COLLABORATE') }}</span>
  </div>
</header>
  <main class="w-full md:max-w-7xl mx-auto">
    <div class="w-full md:max-w-7xl mx-auto sm:px-6 lg:px-8" id="collaborate" style="overflow: auto">
      <!-- Replace with your content -->
        <div class="bg-white w-11/12 mx-auto my-3 md:max-w-lg pb-20">
          <div class="w-3/5 mx-auto rounded-full" style="background: linear-gradient(to right, #06ebbe, #1277d3); padding:6px;">
            <div class="w-full rounded-full bg-white px-1 py-1">
              <img src={{ url('/storage/profile-image/'.$influencerInfo->avatar.'.jpg') }} alt="$influencerInfo->avatar" class="w-full mx-auto rounded-full">
            </div>
          </div>
          <p class="text-center text-black text-lg md:text-xl font-bold">
            {{ $influencerInfo->name }}
          </p>
          <p class="text-center text-gray-500 text-sm md:text-md">
            {{ '@' . $influencerInfo->username }}
          </p>
          <div class="w-full mt-6">
            <form action={{ route('saveRequest') }} method="post" id="requestForm">
              {{ csrf_field() }}
              <input type="text" name="title" id="title" class="w-full rounded-lg bg-gray-100 border-none my-2 @error('title') is-invalid @enderror" placeholder="Project Title" value="{{ old('title') }}">
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <textarea name="detail" id="detail" class="w-full rounded-lg bg-gray-100 border-none my-2 @error('detail') is-invalid @enderror" placeholder="Describe your project" rows='5'>{{ old('detail') }}</textarea>
                @error('detail')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              <div class="attach w-full rounded-lg my-2">
                {{-- file upload --}}
                <div class="w-full min-h-lg sm:py-8">
                  <main class="mx-auto max-w-screen-lg h-full">
                    <!-- file upload modal -->
                    <article aria-label="File Upload Modal" class="relative h-full flex flex-col bg-white rounded-lg">

                      <!-- scroll area -->
                      <section class="h-full w-full h-full flex flex-col">
                        <header class="border-dashed border-2 border-gray-200 py-8 flex flex-col justify-center items-center rounded-lg">
                          <input id="hidden-input" type="file" name="image" class="image hidden" />
                          <a id="button" class="mt-2 rounded-full px-3 py-1 text-white" style="background: #879a9b;">
                            <i class="fas fa-plus-circle text-gray-500 bg-white rounded-full"></i>
                            Attach File
                          </a>
                          <p class="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center underline text-xs md:text-sm text-gray-300">
                            Max size is 20MB.
                          </p>
                          <ul id="gallery" class="w-11/12 mx-auto">
                          </ul>
                        </header>
                      </section>

                      <!-- sticky footer -->
                    </article>
                  </main>
                </div>
                <div class="w-full mx-auto my-5">
                  <p class="text-center text-gray-500 text-sm md:text-md mb-5">
                    How would you like to compensate the influencer?
                  </p>
                  <a class="payMethod active" id="money">
                    <div class="payMethod float-left" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center" style="line-height: 35px">
                          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="42" viewBox="0 0 25 42" style="margin: auto">
                              <defs>
                                  <style>
                                      .cls-1 {
                                          fill: #fff;
                                          fill-rule: evenodd;
                                      }
                                  </style>
                              </defs>
                              <path id="_" data-name="$" class="cls-1" d="M13.079,18.57V8.254a5.794,5.794,0,0,1,3.212,1.618A5.425,5.425,0,0,1,17.768,12.8h5.768a9.188,9.188,0,0,0-3.142-6.049,12.048,12.048,0,0,0-7.315-2.72V0H11.485V3.986A13.738,13.738,0,0,0,5.764,5.112,9.121,9.121,0,0,0,1.895,8.254,8.007,8.007,0,0,0,.512,12.9a7.989,7.989,0,0,0,1.547,5.158,9.269,9.269,0,0,0,3.564,2.79,59.889,59.889,0,0,0,5.862,2.04V33.529A5.97,5.97,0,0,1,7.85,31.653a5.815,5.815,0,0,1-1.524-3.329H0.605a9.292,9.292,0,0,0,3.283,6.495,12.844,12.844,0,0,0,7.6,2.931v3.845h1.594V37.843h0.094a13.327,13.327,0,0,0,6.1-1.266A8.893,8.893,0,0,0,23,33.224,8.69,8.69,0,0,0,24.24,28.7a8.177,8.177,0,0,0-1.43-5.041,9.038,9.038,0,0,0-3.47-2.837,45.5,45.5,0,0,0-5.369-1.969ZM6.233,12.708A4.162,4.162,0,0,1,7.639,9.356a5.933,5.933,0,0,1,3.845-1.243v9.941a11.83,11.83,0,0,1-3.892-2.087,4.115,4.115,0,0,1-1.36-3.259h0ZM13.079,33.67V23.4a12.383,12.383,0,0,1,4.033,2.087,4.162,4.162,0,0,1,1.407,3.353,4.579,4.579,0,0,1-1.43,3.47,5.586,5.586,0,0,1-4.009,1.36h0Z"/>
                          </svg>
                      </p>
                      <p class="text-center text-xs text-gray-500" style="line-height: 25px">
                        Money
                      </p>
                    </div>
                  </a>
                  <a class="payMethod" id="both">
                    <div class="payMethod float-right mx-auto" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center text-gray-500" style="line-height: 35px">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="37" height="45" viewBox="0 0 37 45" style="margin: auto">
                              <defs>
                                  <style>
                                      .cls-1 {
                                          fill: #fff;
                                          fill-rule: evenodd;
                                      }
                                  </style>
                              </defs>
                              <image width="37" height="45" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAtCAYAAAApzaJuAAACoklEQVRYhc2Yu2sUQRyAv9sY4xON8ZKNMQkmEgtTaGehYBNRENRK8A+wEETstLCKgi8E0/gfWF0tWIj4IOKjs7NRsdFC4wPR4JNZfnM3N7Mz2Y3mZj84uJ35zdy38/jN7tUajQb/wGngELARWAN8Bd4Dt4ELi+12mVNSjEngFvABUHd1B3gL1IG9wFHgJHAEeNQJKSX0HJgBTll1L4EnwGVgGpgF9gAPnV4CLEbqGXAROOvUtHMOmAMeAN3ATyfCQ5Jf7OWM/NBCQpprwAvgklMToKzUMeCKUxrmPHAwGGFRRqoH6ALuOjVh7skyGQhGGZSRqgErZfrKoHboCrmpQvgWuurktyW0DvgOrAeWOy38qBw2D6zOaZdIn+13n5M8bwJTwC9L6jHwGuiXXPTHq9HeblZGS8ntstp1yW4+YDbKG6kp6cBmVPLTDhErygjwCtjpabdfpnZeF9hrqlemJ4+P0vhLTl2IT9LucyAmNS9sqX7P6Ck2yHD7pH3odr2eeuyZsaXqTngLdb6tAp4CP5xaP/dlpEJHzZB5YY/KmBPeYkbONrULj8vRUYSrwBtgM3DCEz9hXtgjtdUJb3FDDtfrkjKKouJ3i5yP4dBIpZ5Gin3yKcth+YRo25X2SBU+Cv4zC+6+GNSrKJVK2sgwpdYCg054Z+iT3elIjclTQCzG86SGIwphLvYkrzASA1WUas6UKTXuhHWWiTypLZGlNukvplSsHKVpPr5oqVJvG0tEKvmqKTUiD2Mx6dZPKVoq9nrSZCeKloqdDjSVlMo8qiaVbbbEvKgAlZRSWaApFfuI0SiPnkReEked6jio17fBRKbO91Ycg77E82dGTIaSCq0nzbYqSmUjVZXEqUmV1HanOC6Tatd9A94V/LtwqakBc38B1OlQMqWitSoAAAAASUVORK5CYII="/>
                              <path id="_" data-name="$" class="cls-1" d="M18.7,28.757V23.941a2.7,2.7,0,0,1,1.5.755,2.532,2.532,0,0,1,.69,1.368h2.692a4.289,4.289,0,0,0-1.467-2.824,5.624,5.624,0,0,0-3.415-1.27V20.089H17.959v1.861a6.412,6.412,0,0,0-2.671.525,4.257,4.257,0,0,0-1.806,1.467,4.168,4.168,0,0,0,.077,4.575,4.327,4.327,0,0,0,1.664,1.3,27.907,27.907,0,0,0,2.736.952V35.74a2.788,2.788,0,0,1-1.7-.876,2.715,2.715,0,0,1-.711-1.554H12.881a4.337,4.337,0,0,0,1.532,3.032,6,6,0,0,0,3.546,1.368v1.795H18.7V37.754h0.044a6.22,6.22,0,0,0,2.846-.591,4.151,4.151,0,0,0,1.74-1.565,4.057,4.057,0,0,0,.58-2.112,3.818,3.818,0,0,0-.668-2.353,4.22,4.22,0,0,0-1.62-1.324,21.219,21.219,0,0,0-2.506-.919Zm-3.2-2.736a1.942,1.942,0,0,1,.657-1.565,2.77,2.77,0,0,1,1.8-.58v4.641a5.52,5.52,0,0,1-1.817-.974,1.921,1.921,0,0,1-.635-1.521h0Zm3.2,9.785V31.012a5.783,5.783,0,0,1,1.883.974,1.943,1.943,0,0,1,.657,1.565,2.138,2.138,0,0,1-.668,1.62,2.608,2.608,0,0,1-1.872.635h0Z"/>
                          </svg>
                      </p>
                      <p class="text-center text-xs  text-gray-500" style="line-height: 25px">
                        Both
                      </p>
                    </div>
                  </a>
                  <a class="payMethod" id="gift">
                    <div class="payMethod mx-auto" style="width: 90px; height: 90px; border-radius:50%; background:#eee; border: 1px solid lightgray; padding:15px">
                      <p class="text-3xl text-gray-500 text-center text-gray-500" style="line-height: 35px">
                          <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="35" height="43" viewBox="0 0 35 43" style="margin: auto">
                              <image width="35" height="43" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACMAAAArCAYAAADyijE0AAACeElEQVRYhc2Yv2sUQRTHP7eJCf5I/IFeLhchGA1pjI2dWKiVhUZrCzvBQlvxX9A/w8bmhERUEEHE3kIwltpoQESCEUI0/mLu3sjcvLfrbcjt3AeOY9/M2/nuvB/Dbq3VarFFbgIXgTFgFPgOrANPgbtbueWwsvyffcBLIAPuAw+BFaABXACuANeAM8DHfooZkYWfAZeisS/AMnAHuAd8AA4Aq+ouOZQV8wB4ZQiJuQqMA4+BU2o0hzJiTgDngP1qxOYy8FV8npszIjJlyecG8AL4kTtD8wS4rqw5lBFTB94qazHLEq5tF7MJ/FTWYtYLRyOsnFkAdgO/A9s3YAjYK71ll/LSuHBOyf95aQl/ZFZNHm4R+OU9YzGuFJeMG29KMzsofaVXHgEbsuio4TMDvPcXcZgm1fQOK/JU7ik+q1GbDXmITPwt6qEtFtMwHJAQDcuv1zzLIj+L6SIxxwwHpF+MS86sqVGbNTm3xgq68Fx4ESueUdM7LEr8XTXdBo6oGZrXwC1gB3BWmmZMM7zuNWcWpGe48+a0GrU5KTvyRrqxRdd68c7k5cx8ifB4XCm/U9aC9XpN4H6RW00u8ycqFtMIj4tQTF2aWpXsDKMRiylzVm0XhywxeZXUb/61k1DMXOUyOsxaYnppZP1gyhJTdSWpdUMxVfcYjymmrqZVgyrtkfjQqpBJX95ezLScJSkY8hXlxRxNJMRzOBSTquF5JkIxqSrJ02SAdqa9vheTqpI8XWJSh6krZ1I1PI/bjFomr6qpc8Y1vWYmPWaPGq4Wp2M2i9/qEtLemdQh8jQGScxA7UxbzHFlTsO8e711X7Y/BV+VUlADVv8C2aNRDUME918AAAAASUVORK5CYII="/>
                          </svg>
                      </p>
                      <p class="text-center text-xs  text-gray-500" style="line-height: 25px">
                        Gift
                      </p>
                    </div>
                  </a>
                  <div class="clearfix"></div>
                </div>
                <div class="w-full" id="budgetColumn">
                  <label for="price" class="block text-sm font-medium text-gray-500">Budget</label>
                  <div class="mt-1 relative rounded-md shadow-sm" id="budget">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    </div>
                    <select onchange="onClickCustom()" name="price" id="price" class="block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') is-invalid @enderror" placeholder="0.00" style="height: 38px" value="{{ old('price') }}">
                      <option value="10-30">10-30</option>
                      <option value="30-50">30-250</option>
                      <option value="250-750">250-750</option>
                      <option value="750-1500">750-1500</option>
                      <option id="custom" value="custom">Customise</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center">
                      <label for="currency" class="sr-only">Currency</label>
                      <select id="currency" name="currency" class="h-full py-0 pl-2 pr-7 border-transparent text-black sm:text-sm rounded-r-md bg-gray-100" style="height: 34px; margin-right:2px;">
                        <option value="gbp">GBP</option>
                        <option value="usd">USD</option>
                        <option value="aed">AED</option>
                        <option value="aud">AUD</option>
                        <option value="bgn">BGN</option>
                        <option value="brl">BRL</option>
                        <option value="cad">CAD</option>
                        <option value="chf">CHF</option>
                        <option value="czk">CZK</option>
                        <option value="dkk">DKK</option>
                        <option value="eur">EUR</option>
                        <option value="gbp">GBP</option>
                        <option value="hkd">HKD</option>
                        <option value="huf">HUF</option>
                        <option value="inr">INR</option>
                        <option value="jpy">JPY</option>
                        <option value="mxn">MXN</option>
                        <option value="myr">MYR</option>
                        <option value="nok">NOK</option>
                        <option value="pln">PLN</option>
                        <option value="ron">RON</option>
                        <option value="sek">SEK</option>
                        <option value="sgd">SGD</option>
                      </select>
                      <input type="text" name="files" id="files" hidden>
                    </div>
                  </div>
                </div>
              </div>
              @error('price')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
              <input type="text" name="brand_id" id="brand_id" value="{{ $accountInfo->id }}" hidden>
              <input type="text" name="influencer_id" id="influencer_id" value="{{ $influencerInfo->id }}" hidden>
              <input type="hidden" name="gift" id="giftInput" value="">
              <textarea name="images" id="images" cols="30" rows="10" hidden></textarea>
              <button id="sendRequest" type="submit" class="w-full py-2 text-white rounded-md text-md md:text-lg font-bold mt-5" style="background: #0ac2c8">Send</button>
            </form>
          </div>
        </div>
    </div>
  </main>

  {{-- upload modal --}}
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="img-container">
              <div class="row">
                  <div class="col-md-8">
                      <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                  </div>
                  <div class="col-md-4">
                      <div class="preview"></div>
                  </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="crop">Crop</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    var $modal = $('#modal');
    var image = document.getElementById('image');
    var cropper;
    var filesValue;

    function onClickCustom() {
        var value = $("select#price").val();
        if(value == 'custom') {
            console.log("clicked");
            $('select#price').remove();
            var elem = $("<input name='price' type='text' id='price' value='{{ old('price') }}' class='block w-full pl-3 pr-12 sm:text-sm border-gray-300 rounded-md @error('price') is-invalid @enderror' placeholder='0.00'/>");
            $("div#budget").append(elem);
        }
    }

    const hidden = document.getElementById("hidden-input");
        document.getElementById("button").onclick = () => hidden.click();
        hidden.onchange = (e) => {
        var files = e.target.files;
        var done = function (url) {
          console.log(url);
          image.src = url;
          $modal.modal('show');
        };
        var reader;
        var file;
        var url;

        if (files && files.length > 0) {
          file = files[0];

          if (URL) {
            done(URL.createObjectURL(file));
          } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
              done(reader.result);
            };
            reader.readAsDataURL(file);
          }
        }
    };

    $modal.on('shown.bs.modal', function () {
        cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 3,
        preview: '.preview'
        });
    }).on('hidden.bs.modal', function () {
      cropper.destroy();
      cropper = null;
    });



    $("#crop").click(function(){
        canvas = cropper.getCroppedCanvas({
          width: 160,
          height: 160,
          });

        canvas.toBlob(function(blob) {
          url = URL.createObjectURL(blob);
          var reader = new FileReader();
          reader.readAsDataURL(blob);
          reader.onloadend = function() {
            var base64data = reader.result;
            var element = '<li class="float-left w-1/2 md:w-1/4 px-2 py-2 relative"><img src="" class="w-full rounded-lg"></li>';
            var deleteBtn = '<a class="delete absolute bottom-5 right-5 z-10" onclick="$(this).parent().remove()"><i class=" text-gray-100 hover:text-gray-700 far fa-trash-alt"></i></a>'
            $("ul#gallery").prepend(element);
            $("ul#gallery li:first-child img").attr('src', base64data);
            $("ul#gallery li:first-child").append(deleteBtn);
            $modal.modal('hide');
            }
        });
    });

    $('button#sendRequest').click(function() {
      var imageData = $("ul#gallery img");
      var images = [];
      console.log(imageData);
      if(imageData.length > 0) {
        for (let i = 0; i < imageData.length; i++) {
          const image = imageData[i];
          images.push(image.src);
        }
      }
      $("textarea#images").val(JSON.stringify(images));
    });

  </script>

@endsection
