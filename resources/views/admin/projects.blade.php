@extends('layouts.admin')
@section('content')
  <style>
    span[aria-current='page'] {
      background-color: #1a202c;
      color: white;
    }
  </style>
  <div class="w-full text-white md:hidden" style="background-color: #1f2f46">
    <p class="italic text-lg text-white font-bold leading-8 pr-2" style="font-family: 'Josefin Sans', sans-serif;">{{ __('Projects') }}</p>
  </div>
  <div class="hidden md:block float-left md:w-3/4 lg:w-4/5 xl:w-5/6 pl-5 pt-4">
    <h2 class="text-4xl font-semibold" style="color: #0bc2c8;">{{ __('Projects') }}</h2>
  </div>
  <div class="w-full px-3 py-3 md:float-left md:w-3/4 lg:w-4/5 xl:w-5/6">
  <div id="projects">
    <form action="{{ route('projects') }}" method="get">
    <div class="flex justify-end">
      <div class="relative mb-3">
        <label for="keyword" class="hidden"></label>
        <input type="text" name="keyword" value="{{ ($keyword !== '') ? $keyword : '' }}" class="w-96 rounded-full border-none bg-gray-100 text-gray-500 focus:outline-none focus:border-gray-300" id="keyword" placeholder="Search here" />
        <button type="submit" class="absolute right-2.5 text-gray-500 focus:outline-none focus:text-black" style="top: 50%; transform: translateY(-50%);"><i class="fas fa-search"></i></button>
      </div>
    </div>
    </form>
    <table class="w-full">
      <thead class="w-full bg-gray-300 text-gray-500">
      <tr class="w-full">
        <th style="width:25%" class="py-2 pl-2 rounded-l-md">Project</th>
        <th style="width:18%" class="py-2 pl-2">Influencer</th>
        <th style="width:18%" class="py-2 pl-2">Brand</th>
        <th style="width:13%" class="py-2 pl-2">Type</th>
        <th style="width:13%" class="py-2 pl-2">Status</th>
        <th style="width:13%" class="py-2 pl-2 rounded-r-md">Details</th>
      </tr>
      </thead>
      <tbody>
      @foreach($projects as $project)
        <tr>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $project->title }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $project->influencer_name }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ $project->brand_name }}</td>
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">{{ ($project->gift !== 0)?'Paid':'Gifted' }}</td>
          @switch($project->status)
            @case (1)
              <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">Posted</td>
              @break
            @case (2)
              <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">Accepted</td>
              @break
            @case (4)
              <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">Completed</td>
              @break
            @case (5)
              <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm">Disputed</td>
              @break
          @endswitch
          <td class="py-3 pl-2 border-bottom border-gray-200 text-gray-500 text-sm"><a href="#" class="block border border-gray-400 rounded-md px-3 py-2">View Details</a></td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $projects->links() }}
  </div>
  @endsection
