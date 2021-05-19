@extends('layouts.admin')
@section('content')
  <style>
    table tr td {
      padding: 17px 0;
    }
    table tr th {
      padding: 10px 0;
    }
  </style>
  <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
    <p class="italic text-lg text-white font-bold leading-8 pr-2" style="font-family: 'Josefin Sans', sans-serif;">{{ __('HOME') }}</p>
  </div>
  <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
    <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">Hi, Welcome</h2>
    <p class="text-gray-500">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
  </div>
  <div class="px-2 w-full md:float-left md:px-5 lg:px-5 md:w-3/4 lg:w-4/5 xl:w-5/6">
    <div class="w-full lg:grid lg:grid-cols-3 lg:gap-x-3">
      <div class="col-span-1 px-2 py-2">
        <div class="w-full rounded-xl bg-white px-4 py-3 shadow-sm">
          <div class="flex justify-between text-3xl text-gray-400">
            <div>
              <span class="text-3xl font-bold text-gray-500">{{ $user_count }}</span><br/>
              <span class="text-sm tracking-widest text-gray-500">TOTAL USERS</span>
            </div>
            <div>
              <img src="{{ asset('img/total users.png') }}" alt="total users" width="64">
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-1 px-2 py-2">
        <div class="w-full rounded-xl bg-white px-4 py-3 shadow-sm">
          <div class="flex justify-between text-3xl text-gray-400">
            <div>
              <span class="text-3xl font-bold text-gray-500">{{ $influencer_count }}</span><br/>
              <span class="text-sm tracking-widest text-gray-500">INFLUENCERS</span>
            </div>
            <div>
              <img src="{{ asset('img/influencers.png') }}" alt="total users" width="64">
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-1 px-2 py-2">
        <div class="w-full rounded-xl bg-white px-4 py-3 shadow-sm">
          <div class="flex justify-between text-3xl text-gray-400">
            <div>
              <span class="text-3xl font-bold text-gray-500">{{ $brand_count }}</span><br/>
              <span class="text-sm tracking-widest text-gray-500">BRANDS</span>
            </div>
            <div>
              <img src="{{ asset('img/brands.png') }}" alt="total users" width="64">
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full lg:grid lg:grid-cols-3 lg:gap-x-3">
      <div class="col-span-2 px-2 py-2">
        <p class="text-md text-gray-500 font-bold">Projects</p>
        <div class="px-2 py-2 w-full bg-white rounded-xl shadow-sm">
          <div class="flex justify-between mt-3">
            <div class="grid grid-cols-2 gap-x-1 md:gap-x-2 gap-y-2">
              <div class="col-span-1">
                <div class="w-3 h-3 md:w-5 md:h-5 rounded-sm float-left bg-blue-500"></div>
                <div class="float-left"><p class="text-xs md:text-sm text-gray-500 ml-1 md:ml-3 ">Completed</p></div>
                <div class="clearfix"></div>
              </div>
              <div class="col-span-1">
                <div class="w-3 h-3 md:w-5 md:h-5 rounded-sm float-left bg-red-500"></div>
                <div class="float-left"><p class="text-xs md:text-sm text-gray-500 ml-1 md:ml-3 ">Disputed</p></div>
                <div class="clearfix"></div>
              </div>
              <div class="col-span-1">
                <div class="w-3 h-3 md:w-5 md:h-5 rounded-sm float-left bg-yellow-500"></div>
                <div class="float-left"><p class="text-xs md:text-sm text-gray-500 ml-1 md:ml-3 ">In Progress</p></div>
                <div class="clearfix"></div>
              </div>
              <div class="col-span-1">
                <div class="w-3 h-3 md:w-5 md:h-5 rounded-sm float-left bg-green-500"></div>
                <div class="float-left"><p class="text-xs md:text-sm text-gray-500 ml-1 md:ml-3" >Accepted</p></div>
                <div class="clearfix"></div>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-x-2">
              <div class="col-span-1">
                <label for="year"></label>
                <select name="year" id="year" class="text-xs md:text-sm border-none bg-gray-200 text-gray-500 rounded-lg focus:ring-0" style="padding: 4px 26px 4px 12px;">
                  @for($i = 2021; $i <= date('Y'); $i ++)
                    <option value="$i">{{ $i }}</option>
                  @endfor
                </select>
              </div>
              <div class="col-span-1">
                <label for="month"></label>
                <select name="month" id="month" class="text-xs md:text-sm border-none text-gray-500 bg-gray-200 text-gray-500 rounded-lg focus:ring-0" style="padding: 4px 26px 4px 12px;">
                  <option value='1'>Jan</option>
                  <option value='2'>Feb</option>
                  <option value='3'>Mar</option>
                  <option value='4'>Apr</option>
                  <option value='5'>May</option>
                  <option value='6'>Jun</option>
                  <option value='7'>Jul</option>
                  <option value='8'>Aug</option>
                  <option value='9'>Sep</option>
                  <option value='10'>Oct</option>
                  <option value='11'>Nov</option>
                  <option value='12'>Dec</option>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-span-1 px-2 py-2">
        <p class="text-md text-gray-500 font-bold">Type of Projects</p>
        <div class="w-full px-2 py-2 bg-white rounded-xl shadow-sm h-96">
          <div class="w-full grid grid-cols-2 gap-x-2 mt-3">
            <div class="col-span-1">
              <select name="year" id="year" class="w-full text-xs md:text-sm border-none text-gray-500 bg-gray-200 text=gray-500 rounded-lg focus:ring-0">
                @for($i = 2021; $i <= date('Y'); $i ++)
                  <option value="$i">{{ $i }}</option>
                @endfor
              </select>
            </div>
            <div class="col-span-1">
              <select name="month" id="month" class="w-full text-xs md:text-sm border-none bg-gray-200 text-gray-500 rounded-lg focus:ring-0">
                <option value='1'>Jan</option>
                <option value='2'>Feb</option>
                <option value='3'>Mar</option>
                <option value='4'>Apr</option>
                <option value='5'>May</option>
                <option value='6'>Jun</option>
                <option value='7'>Jul</option>
                <option value='8'>Aug</option>
                <option value='9'>Sep</option>
                <option value='10'>Oct</option>
                <option value='11'>Nov</option>
                <option value='12'>Dec</option>
              </select>
            </div>
          </div>
          <div class="c100 big mt-8 p{{$gifted}}">
            <div class="slice">
              <div class="bar"></div>
              <div class="fill"></div>
            </div>
          </div>
          <div class="clearfix"></div>
          <div class="w-full flex justify-evenly">
            <div>
              <div class="flex between">
                <div class="w-5 h-5 bg-blue-500"></div>
                <div><p class="text-blue text-md ml-2">{{ $gifted }}%</p></div>
              </div>
              <p class="text-sm text-gray-400">Gifted</p>
            </div>
            <div>
              <div class="flex between">
                <div class="w-5 h-5 bg-yellow-500"></div>
                <div><p class="text-blue text-md ml-2">{{ $paid }}%</p></div>
              </div>
              <p class="text-sm text-gray-400">Paid</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="w-full px-2 py-2">
    <p class="text-md text-gray-500 font-bold">Most Recent Referrals</p>
    <div class="px-2 py-2 rounded-xl bg-white shadow-sm">
      <div>
        <table class="w-full">
          <thead>
          <tr class="py-2 border-b border-gray-400">
            <th style="width: 25%" class="text-xs md:text-lg">Influencer</th>
            <th style="width: 25%" class="text-xs md:text-lg">Referred by</th>
            <th style="width: 25%" class="text-xs md:text-lg">Location</th>
            <th style="width: 25%" class="text-xs md:text-lg">Social media</th>
          </tr>
          </thead>
          <tbody>
          @foreach($referrals as $referral)
          <tr class="py-2">
            <td style="width: 25%" class="text-xs md:text-lg"><img src="{{ url('storage/profile-image/'.$referral->influencerInfo->avatar.'.jpg') }}" alt="{{ $referral->influencerInfo->avatar }}">{{ $referral->influencerInfo->name }}</td>
            <td style="width: 25%" class="text-xs md:text-lg"><img src="{{ url('storage/profile-images/'.$referral->referral_userInfo->avatar.'.jpg') }}" alt="{{ $referral->referral_userInfo->avatar }}">{{ $referral->referral_userInfo->name }}</td>
            <td style="width: 25%" class="text-xs md:text-lg">{{ $referral->influencerInfo->state.', '.$referral->influencerInfo->country }}</td>
            <td style="width: 25%" class="text-xs md:text-lg">
              <div class="w-full grid grid-cols-3 gap-x-2">
                <div class="col-span-1">
                  <a href="{{ $referral->influencerProfile->instagram }}" class="text-center leading-10"><i class="fab fa-instagram" style="background:-webkit-linear-gradient(#792ec5, #c62e71, #da8a40);-webkit-background-clip: text;-webkit-text-fill-color: transparent;"></i></a>
                </div>
                <div class="col-span-1">
                  <a href="{{ $referral->influencerProfile->youtube }}" class="text-center leading-10 text-red-700"><i class="fab fa-youtube"></i></a>
                </div>
                <div class="col-span-1">
                  <a href="{{ $referral->influencerProfile->tiktok }}" class="text-center leading-10"><i class="fab fa-tiktok"></i></a>
                </div>
              </div>
            </td>
          </tr>
          @endforeach
          </tbody>
        </table>
      </div>
      <div>
        <a class="text-sm md:text-lg float-right text-gray-400 hover:decoration-none">View more</a>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
@endsection
