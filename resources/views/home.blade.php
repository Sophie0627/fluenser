@extends('layouts.app')

@section('content')
<script src="https://js.stripe.com/v3/"></script>
<header class="bg-white">
    <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
      <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('HOME') }}</p>
    </div>
    <div class="w-full md:max-w-7xl mx-auto px-2 h-8" style="border-bottom: 1px solid lightgray">
        <span class="mx-4 px-1 pt-2 pb-1 font-bold text-sm md:text-md leading-8" style="border-bottom: 2px solid #4db3c1">{{ __('NEWS FEED') }}</span>
    </div>
    @if ($url != '')
        <div class="w-full md:max-w-7xl mx-auto">
            <a onclick="location.href='{{ $url }}'">
                <div class="w-11/12 mx-auto rounded-xl px-2 py-2 mt-3" style="box-shadow: 0 0 10px 0 #999">
                    <div class="float-left px-1 py-1 rounded-full my-3" style="background: #c2c2c2">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="33" height="33" viewBox="0 0 33 33">
                            <image width="33" height="33" xlink:href="data:img/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAhCAYAAABX5MJvAAAETUlEQVRYhcWXX0xbVRzHv+fce1toKyGIILSFqg3rzApx0wQCY41AZjIfTKaJccYsZosalvlmRnzzZYuPBpxmezBb9EUXH5Y4CDMhMwyXMecsYYw/WxcoMMbIVQrr2t57zCnthfS0tBRXP0lzk3t+5/f79txzfuf3k7ANfIDsg8tUChUBQM/XExHebIIbbnNXVaUXEm0ijL100OIqtylFSigajl5YDSwyQqag6UMn5x74JzH5JLOnLYp4B5C8z7/m6SzdsV8iOGIlSg0AEwC+inSDKV8JDUBkRY9Na2BnelR/n3/+1tiPa+8zsqkIX6mr9Fz5q+9VmZ45BqAuEThXeODxuchy9weLwz8MqAE107xMIki/rd1T76w4WUbMHQAsgkXurC5pT/r/Ci50dYQujwFgQrA0rsivtftfabXavwJYszCaN2TwykrweNv9vpupQoTl7be179xXbv8GBE0ZROaLo1ax1beGy6+ej9xdzCiC74FjVZ7uYip3ZBXgeA5kbz2IxwlS5wCJaoAaEsw2QECIs8RW5BjWlnsDYTUsiOCn4GvHgQ8rFfPHABTBRQr09d2QTrwL2rYbtMULLKhgt6YEu1SKqVzTZrY/CC75/xhNfBbjiPFjaDeZOnPehJoGmBWg2Lz21HLOVRYeh8dLvjBE8DyQOIaFoC4Rb10Ez4QSyNF0G/UpIfF4PK4h4jN7xU4rlZ0FEhCHxztRXf2yIYIyqSWRiguJiVF977oIwtwF/BRJZKoTdzw+v44P2l4oT7mMCgF521pbtgdQqAsu2UblrHnhaWCTFcULl0QDCMRCeiz6f4gIxaJRPwIaHQBiF0L3FrHVykiRAZLI7PxpkgWTLLCfVu4v3QCi8Zk6I5OJ+z/nfcFGAtC7f46feOgMbHhcsMlCTKeMx0VCPhnkFVEud4YhYnw6/tsGEaLT35D856dmZ0d5SbZVf2RfA+jnh0AONApj2eDxeFxjJXhRqqHxDIAvc80XpHkXpFNHgRIL8FYLNErALg4JdhnQotDPJothYw/0qHf6eE2Yfo4I8dSs3aCcIhPIi9WCzSZMnFZHepPDhgj//PWxYCTSw2vCzHPXYddug00vALyYmXsENnxHsMnAajAS6eZVeHLYWHpeYPypL0+8abE3FFNpR/r5G1hQgfEZYOQe9ItDYEOjgkk6lrTIpfcfDn7xS1h9nBwWSjheY/qcjrMgpPE/TuU6GPt9YHrmSEfo8u2NA8ImPB+5+8hnrbxZayrxAqgRXOUNuXpldfZ4+8P+kVQPggjOub+n5lsfPztUYjM7i9fqjO3cLatLWvjStZm5TxMCcuo7DHj1/V3FnkN2uaQzzw5sIhj7p/vwwo3v8+nADNZ60QbPJ2W73lB06SMrlaqz96LabBTat6fV8V5+6rbVi6biBsxdVc1eENpESKIrlxWF34bxrpyRKTDelQ/6J4Gcu/JtwQuSw3AV8WfejgD8C4KJhaluEmg4AAAAAElFTkSuQmCC"/>
                          </svg>
                    </div>
                    <div class="float-right py-2 px-1 my-2">
                        <i class="fas fa-chevron-right text-gray-500" style="line-height: 1.75rem"></i>
                    </div>
                    <p class="text-sm md:text-md font-bold pl-14">Connect to Stripe</p>
                    <p class="text-gray-500 text-xs md:text-sm tracking-tighter pl-14">We've partnered with stripe for fast, secure payments. Fill out a few more details to complete your profile and start getting paid.</p>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    @endif
  </header>

	<main class="w-full md:max-w-7xl mx-auto pb-20">
		<!--@foreach ($portfolios as $portfolio)-->
		<!--		<div class="w-11/12 mx-auto rounded-xl mt-3 pb-3" style="box-shadow: 0 0 10px 0 #999">-->
		<!--			<img class="w-full rounded-t-xl" src="{{ url('/storage/profile-image/'.$portfolio->slide_img.'.jpg') }}" alt={{ $portfolio->slide_img }}>-->
		<!--			<div class="w-full rounded-b-xl mt-3">-->
		<!--				<p class="text-md md:text-lg font-bold pl-3">There are many variations of passages</p>-->
		<!--				<div class="mt-2 w-11/12 mx-auto">-->
		<!--					<div class="float-left w-14 h-14">-->
		<!--						<img class="w-full rounded-full" src="{{ url('/storage/profile-image/'.$accountInfo->avatar.'.jpg') }}" alt={{ $accountInfo->avatar }}>-->
		<!--					</div>-->
		<!--					<div class="float-left h-14 py-1 pl-3">-->
		<!--						<p class="text-sm:md:text-md leading-6 font-bold">{{ $accountInfo->name }}</p>-->
		<!--						<p class="text-xs:md:text-sm leading-6">{{ '@'.$accountInfo->username }}</p>-->
		<!--					</div>-->
		<!--					<div class="clearfix"></div>-->
		<!--				</div>-->
		<!--			</div>-->
		<!--		</div>-->
		<!--@endforeach-->
	</main>
@endsection
