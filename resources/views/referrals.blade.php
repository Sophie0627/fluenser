@extends('layouts.app')

@section('content')
<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <span><a href="{{ route('home') }}" class="text-white"><i class="fas fa-chevron-left"></i></a></span>
    <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('REFERRALS') }}</span>
  </div>
</header>
<main class="md:max-w-7xl mx-auto">
  <div class="w-full md:max-w-7xl mx-auto sm:px-6 lg:px-8 mt-3 mb-20">
    <div class="w-11/12 mx-auto">
      <p class="text-xl md:text-2xl font-bold text-center">Referrals</p>
      <p class="text-sm md:text-md mt-3">
        Our referral program seeks genuine partners, to share our growth and future profits. Partners are paid on the first calendar day of each month, directly into their chosen bank account.
      </p>
      <ul class="mt-3" style="list-style-type: disc; margin-left:20px;">
        <li class="text-sm md:text-md">Use your referral link to sign up fellow influencers and earn 10% of all the income they make! Don't worry they still get their 85%. </li>
        <li class="text-sm md:text-md">You can share your Referral Link with anyone you believe would be great to join Fluenser. </li>
        <li class="text-sm md:text-md">In order to receive Referral income, the person
          must sign up using your unique referral link. </li>
      </ul>
    </div>
    <div class="w-11/12 mx-auto">
      <div class="w-full mt-4">
        <label class="text-xs w-full" for="ref_link">
          Referral Link
          <div class="w-full relative">
            <input type="text" class="rounded-lg border-none w-full bg-gray-200 px-2 py-2" value="{{ $ref_link }}" readonly id="ref_link">
            <button class="block h-full px-3 py-2 rounded-r-lg absolute right-0 top-0 text-white" style="background: #0ac2c8" onclick="saveToClipboard()" id="ref_copy">Copy</button>
          </div>
        </label>
      </div>
      <div class="w-full mt-4 text-xs">
        <div class="grid grid-cols-2 gap-x-5">
          <div class="col-span-1">
            <label for="total_ref" class="w-full">
              Total Referrals
              <input type="text" class="w-full rounded-lg bg-gray-200 border-none" value="{{ $count }}" readonly>
            </label>
          </div>
          <div class="col-span-1">
            <label for="earned_amount" class="w-full">
              Amount Earned
              <input type="text" class="w-full rounded-lg bg-gray-200 border-none" value="{{ $earned }}" readonly>
            </label>
          </div>
        </div>
      </div>
      <div class="w-full mt-3 text-xs">
        Reffered Users
        <div class="rounded-t-lg" style="box-shadow:0 0 3px 3px lightgray;">
          <div id="tb_header" class="bg-gray-900 rounded-t-lg text-white py-2 text-center tracking-tighter" style="font-size: 10px;">
            <div style="width: 32%; float:left; text-center">Influencer</div>
            <div style="width: 11%; float:left; text-center">Gifted project</div>
            <div style="width: 11%; float:left; text-center">Paid project</div>
            <div style="width: 28%; float:left; text-center">Influencer earnings</div>
            <div style="width: 18%; float:left; text-center">My Earnings</div>
            <div class="clearfix"></div>
          </div>
          <div id="tb_body" class="text-center">
            @foreach ($referrals as $referral)
                <div class="w-full bg-white py-3" style="border-bottom:1px solid #333;">
                  <div style="width: 32%; float:left; text-center" class="relative">
                    <img src="{{ url('/storage/profile-image/' . $referral->influencerInfo->avatar . '.jpg') }}" alt="{{ $referral->influencerInfo->avatar  }}" class="absolute rounded-full w-10 left-2" style="top:50%; transform:translateY(-50%);">
                    <span class="ml-10">
                      {{ $referral->influencerInfo->name }}
                    </span>
                  </div>
                  <div style="width: 11%; float:left; text-center">{{ $referral->influencerInfo->giftedCount }}</div>
                  <div style="width: 11%; float:left; text-center">{{ $referral->influencerInfo->paidCount }}</div>
                  <div style="width: 28%; float:left; text-center">{{ $referral->influencerInfo->earned }}</div>
                  <div style="width: 18%; float:left; text-center">{{ $referral->influencerInfo->earned / 10 }}</div>
                  <div class="clearfix"></div>
                </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

<script>
  function saveToClipboard() {
    var ref_link = $("input#ref_link").val();
    navigator.clipboard.writeText(ref_link).then(function() {
      $("button#ref_copy").html('Copied');
    }, function() {
    });
  }
</script>
@endsection
