@extends('layouts.app')
@section('content')
<div id="depositModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <form action="{{ route("checkout") }}" method="POST">
        @csrf
        <div class="w-11/12 h-48 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
          <div class="rounded-t-md h-10 pt-1" style=" background:linear-gradient(to right, RGB(5,235,189), RGB(19,120,212));">
            <p class="text-md md:text-lg text-center text-white font-bold leading-10">Deposit Funds</p>
            <a class="block h-6 w-6 absolute -top-2 -right-2 rounded-full bg-white text-center" onclick="$('div#depositModal').hide()" style="boxShadow: 0 0 8px #353535">
              <span class="leading-6"><i class="fas fa-times"></i></span>
            </a>
          </div>
          <div class="w-11/12 mx-auto grid grid-cols-2 gap-x-4">
            <div class="col-span-1">
              <label for="price" class="block text-xs md:text-sm font-medium text-gray-700 mt-4">Project Amount<sup style="color:red">*</sup>
              </label>
              <input name="price" type="number" id="price" class="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none"/>
            </div>
            <div class="col-span-1">
              <label for="price" class="block text-xs md:text-sm font-medium text-gray-700 mt-4">Currency<sup style="color:red">*</sup>
              </label>
              <select name='currency' id="currency" class="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none">
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
            </div>
          </div>
          <div class="w-11/12 mx-auto mt-4">
            <button type='submit' class="block mx-auto px-4 py-2 rounded-sm text-white text-sm md:text-md font-semibold"
                    style="background:#0ac2c8; boxShadow:0 4px 6px rgb(50 50 93), 0 1px 3px rgb(0 0 0)">
              Deposit
            </button>
          </div>
        </div>
    </form>
  </div>

  <div id="withdrawModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50 hidden">
    <form action="{{ route("withdraw") }}" method="POST">
        @csrf
        <div class="w-11/12 h-48 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
          <div class="rounded-t-md h-10 pt-1" style=" background:linear-gradient(to right, RGB(5,235,189), RGB(19,120,212));">
            <p class="text-md md:text-lg text-center text-white font-bold leading-10">Withdraw Money</p>
            <a class="block h-6 w-6 absolute -top-2 -right-2 rounded-full bg-white text-center" onclick="$('div#withdrawModal').hide()" style="boxShadow: 0 0 8px #353535">
              <span class="leading-6"><i class="fas fa-times"></i></span>
            </a>
          </div>
          <div class="w-11/12 mx-auto grid grid-cols-2 gap-x-4">
            <div class="col-span-1">
              <label for="price" class="block text-xs md:text-sm font-medium text-gray-700 mt-4">Project Amount<sup style="color:red">*</sup>
              </label>
              <input name="price" type="number" id="price" class="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none"/>
            </div>
            <div class="col-span-1">
              <label for="price" class="block text-xs md:text-sm font-medium text-gray-700 mt-4">Currency<sup style="color:red">*</sup>
              </label>
              <select name='currency' id="currency" class="w-full rounded-lg text-xs md:text-sm bg-gray-200 text-gray-500 border-none">
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
            </div>
          </div>
          <div class="w-11/12 mx-auto mt-4">
            <button type='submit' class="block mx-auto px-4 py-2 rounded-sm text-white text-sm md:text-md font-semibold"
                    style="background:#0ac2c8; boxShadow:0 4px 6px rgb(50 50 93), 0 1px 3px rgb(0 0 0)">
              Withdraw
            </button>
          </div>
        </div>
    </form>
  </div>
  @if (isset($message) && $message != '')
    <div id="messageModal" class="h-screen w-screen bg-black bg-opacity-70 fixed top-0 z-50">
        <div class="w-11/12 bg-white absolute rounded-xl" style="top:50%; margin-top:-6rem; left:50%; margin-left:-45.83333%;" id="modalBody">
            <div class="float-right pr-2 pt-2">
                <a onclick="$('div#messageModal').fadeOut(200);"><i class="fas fa-times"></i></a>
            </div>
            <div class="w-10/12 mx-auto mt-4 mb-8 flex justify-evenly py-5 text-center">
                {{ $message }}
            </div>
        </div>
    </div>
  @endif

<header class="bg-white">
  <div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
    <p class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('BALANCE') }}</p>
  </div>
</header>
  <main class="w-full md:max-w-7xl mx-auto">
    <div class="w-full md:max-w-7xl mx-auto sm:px-6 lg:px-8" id="collaborate" style="overflow: auto">
      <div class="w-11/12 mx-auto">
        <div class="w-full rounded-xl mt-3 relative" style="background: #119dab">
          <img src={{ asset('img/wallet.png') }} alt="wallet" class="w-full rounded-xl" style="opacity: 0.36">
          <div class="w-full absolute left-0 text-center" style="top: 50%; transform:translateY(-50%);">
            <div class="balance text-white">
              <p class="text-lg md:text-xl">BALANCE</p>
              <span class="text-2xl md:text-3xl font-bold my-3" id="balance">{{ number_format($wallet->usd_balance, 2) }}</span>
              <select id="balance_currency" class="text-2xl md:text-3xl font-bold my-3" style="background-color: transparent; border:none; outline:none" onchange="showBalance()">
                <option class="text-black" value="usd">USD</option>
                <option class="text-black" value="aed">AED</option>
                <option class="text-black" value="aud">AUD</option>
                <option class="text-black" value="bgn">BGN</option>
                <option class="text-black" value="brl">BRL</option>
                <option class="text-black" value="cad">CAD</option>
                <option class="text-black" value="chf">CHF</option>
                <option class="text-black" value="czk">CZK</option>
                <option class="text-black" value="dkk">DKK</option>
                <option class="text-black" value="eur">EUR</option>
                <option class="text-black" value="gbp">GBP</option>
                <option class="text-black" value="hkd">HKD</option>
                <option class="text-black" value="huf">HUF</option>
                <option class="text-black" value="inr">INR</option>
                <option class="text-black" value="jpy">JPY</option>
                <option class="text-black" value="mxn">MXN</option>
                <option class="text-black" value="myr">MYR</option>
                <option class="text-black" value="nok">NOK</option>
                <option class="text-black" value="pln">PLN</option>
                <option class="text-black" value="ron">RON</option>
                <option class="text-black" value="sek">SEK</option>
                <option class="text-black" value="sgd">SGD</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="w-full bg-gray-200 px-2 py-3 mt-3">
        <div class="flex justify-center md:justify-around">
          <div class="mx-2">
            <button class="w-full rounded-lg py-2 px-3 text-white" style="background: #119dab;font-size:12px;" onclick="$('div#depositModal').show();">Deposit Funds</button>
          </div>
          <div class="mx-2">
            <button class="w-full rounded-lg text-white px-3 py-2 bg-gray-500" style="font-size: 12px;" onclick="$('div#withdrawModal').show();">Withdraw Money</button>
          </div>
        </div>
      </div>
      <div class="w-11/12 mx-auto">
        <div class="h-10 mt-3">
          <p class="text-md md:text-lg leading-10 font-bold">Transactions</p>
        </div>
        <div class="w-full mt-3 overflow-auto" id="transaction">
            <div>
                @foreach ($walletActions as $action)
                    <div class="w-full py-2 h-16" style="border-bottom: 1px solid #999">
                      <div class="flex justify-between">
                        <div>
                          <p class="text-xs md:text-sm leading-6">{{ date_create($action->created_at)->format('Y-m-d h:i') }}</p>
                        </div>
                        <div>
                          <p class="text-xs md:text-sm leading-10 py-2">
                            @if ($action->aaa == '+')
                              <span class="text-green-500">{{ $action->aaa }}</span>
                            @else
                              <span class="text-red-500">{{ $action->aaa }}</span>
                            @endif
                            <span>{{ number_format($action->amount, 2).' '.strtoupper($action->currency) }}</span>
                          </p>
                        </div>
                      </div>
                    </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
  </main>
<script>
  function showBalance() {
    console.log("changed");
    const currency = $("select#balance_currency").val();
    console.log(currency);
    switch (currency) {
      case 'usd':
        $("span#balance").text("{{ number_format($wallet->usd_balance, 2) }}");
        break;
      case 'gbp':
        $("span#balance").text("{{ number_format($wallet->gbp_balance, 2) }}");
        break;
      case 'eur':
        $("span#balance").text("{{ number_format($wallet->eur_balance, 2) }}");
        break;
      case 'aed':
        $("span#balance").text("{{ number_format($wallet->aed_balance, 2) }}");
        break;
      case 'aud':
        $("span#balance").text("{{ number_format($wallet->aud_balance, 2) }}");
        break;
      case 'bgn':
        $("span#balance").text("{{ number_format($wallet->bgn_balance, 2) }}");
        break;
      case 'brl':
        $("span#balance").text("{{ number_format($wallet->brl_balance, 2) }}");
        break;
      case 'cad':
        $("span#balance").text("{{ number_format($wallet->cad_balance, 2) }}");
        break;
      case 'chf':
        $("span#balance").text("{{ number_format($wallet->chf_balance, 2) }}");
        break;
      case 'czk':
        $("span#balance").text("{{ number_format($wallet->czk_balance, 2) }}");
        break;
      case 'dkk':
        $("span#balance").text("{{ number_format($wallet->dkk_balance, 2) }}");
        break;
      case 'hkd':
        $("span#balance").text("{{ number_format($wallet->hkd_balance, 2) }}");
        break;
      case 'huf':
        $("span#balance").text("{{ number_format($wallet->huf_balance, 2) }}");
        break;
      case 'inr':
        $("span#balance").text("{{ number_format($wallet->inr_balance, 2) }}");
        break;
      case 'jpy':
        $("span#balance").text("{{ number_format($wallet->jpy_balance, 2) }}");
        break;
      case 'mxn':
        $("span#balance").text("{{ number_format($wallet->mxn_balance, 2) }}");
        break;
      case 'myr':
        $("span#balance").text("{{ number_format($wallet->myr_balance, 2) }}");
        break;
      case 'nok':
        $("span#balance").text("{{ number_format($wallet->nok_balance, 2) }}");
        break;
      case 'pln':
        $("span#balance").text("{{ number_format($wallet->pln_balance, 2) }}");
        break;
      case 'ron':
        $("span#balance").text("{{ number_format($wallet->ron_balance, 2) }}");
        break;
      case 'sek':
        $("span#balance").text("{{ number_format($wallet->sek_balance, 2) }}");
        break;
      case 'sgd':
        $("span#balance").text("{{ number_format($wallet->sgd_balance, 2) }}");
        break;
      default:
        break;
    }
  }
</script>
@endsection
