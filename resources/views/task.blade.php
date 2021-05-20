@extends('layouts.app')

@section('content')
<div class="w-full md:max-w-7xl mx-auto py-1 px-3 sm:px-6 lg:px-8 bg-gray-800 h-10">
  <span class="italic text-lg md:text-xl text-white font-bold leading-8" style="font-family: 'Josefin Sans', sans-serif;">{{ __('COLLABORATIONS') }}</span>
</div>
<div class="w-full md:max-w-7xl mx-auto px-2 h-8" style="border-bottom: 1px solid lightgray" id="collTab">
    <a class="active mx-2 px-1 pt-2 pb-1 font-bold text-sm md:text-md leading-8 collTab" onclick="openTab('accepted')" id="accepted">{{ __('ACCEPTED') }}</a>
    <a class="mx-2 px-1 pt-2 pb-1 font-bold text-sm md:text-md leading-8 collTab" onclick="openTab('completed')" id="completed">{{ __('COMPLETED') }}</a>
    <a class="mx-2 px-1 pt-2 pb-1 font-bold text-sm md:text-md leading-8 collTab" onclick="openTab('disputed')" id="disputed">{{ __('DISPUTED') }}</a>
</div>
<main>
  <div class="w-full md:max-w-7xl mx-auto overflow-auto pb-3" id="tabContainer">
    <div class="tabContent w-11/12 mx-auto" id="accepted" >
      @foreach ($acceptedTasks as $task)
          <a href="{{ route('taskDetail', ['request_id' => $task->request_id ]) }}" class="block relative w-full mt-3 rounded px-3 py-3" style="box-shadow: 0 0 8px 0 #999">
            <p class="text-md md:text-lg font-bold">{{ $task->title }}</p>
            <p class="text-xs md:text-sm text-gray-500">
              <span>{{ $task->name }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @if ($task->gift == 1)
                  <span>Gift</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @else
                  <span>{{ $task->amount . ' ' . strtoupper($task->unit) }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @endif
              <span>{{ $task->interval. ' ago' }}</span>
            </p>
            <div class="absolute right-3" style="top: 50%; transform:translateY(-50%)">
              <span style="color: #53b5c1"><i class="fas fa-chevron-right"></i></span>
            </div>
            @if ($task->unread)
              <div id="notif" class="w-2 h-2 rounded-full bg-red-500 absolute top-1 right-1"></div>
            @else
              <div id="notif" class="w-2 h-2 rounded-full bg-red-500 absolute top-1 right-1" style="display: none;"></div>
            @endif
          </a>
      @endforeach
    </div>
    <div class="tabContent w-11/12 mx-auto" id="completed">
      @foreach ($completedTasks as $task)
          <a href="{{ route('taskDetail', ['request_id' => $task->request_id ]) }}" class="block w-full mt-3 rounded px-3 py-3 relative" style="box-shadow: 0 0 8px 0 #999">
            <p class="text-md md:text-lg font-bold">{{ $task->title }}</p>
            <p class="text-xs md:text-sm text-gray-500">
              <span>{{ $task->name }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @if ($task->gift == 1)
                  <span>Gift</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @else
                  <span>{{ $task->amount . ' ' . strtoupper($task->unit) }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @endif
              <span>{{ $task->interval. ' ago' }}</span>
            </p>
            <div class="absolute right-3" style="top: 50%; transform:translateY(-50%)">
              <span style="color: #53b5c1"><i class="fas fa-chevron-right"></i></span>
            </div>
          </a>
      @endforeach
    </div>
    <div class="tabContent w-11/12 mx-auto" id="disputed">
      @foreach ($disputedTasks as $task)
          <a href="{{ route('disputeChat', ['request_id' => $task->request_id ]) }}" class="block w-full mt-3 rounded px-3 py-3 relative" style="box-shadow: 0 0 8px 0 #999">
            <p class="text-md md:text-lg font-bold">{{ $task->title }}</p>
            <p class="text-xs md:text-sm text-gray-500">
              <span>{{ $task->name }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @if ($task->gift == 1)
                  <span>Gift</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @else
                  <span>{{ $task->amount . ' ' . strtoupper($task->unit) }}</span>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
              @endif
              <span>{{ $task->interval. ' ago' }}</span>
            </p>
            <div class="absolute right-3" style="top: 50%; transform:translateY(-50%)">
              <span style="color: #53b5c1"><i class="fas fa-chevron-right"></i></span>
            </div>
          </a>
      @endforeach
    </div>
  </div>
</main>
<script>
  openTab('{{ $item }}');
  function openTab(id) {
    $("div#collTab a.collTab").removeClass('active');
    $("div#collTab a.collTab#" + id).addClass('active');
    $("div.tabContent").hide();
    $("div#" + id).show();
  }

  $("div#tabContainer").css('height', innerHeight - 130);
</script>
@endsection
