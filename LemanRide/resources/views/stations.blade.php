@extends('layouts.app')
@section('content')

<div class="titles text-center text-white font-bold p-10">
    <h1 class="title lg:text-6xl text-4xl mb-5">Stations</h1>
</div>

<div class="flex justify-center">

    <div class="stations flex flex-col lg:flex-row items center bg-fixed bg-center">

            @foreach ($data as $station)
            <div class="station flex flex-col items-center m-10">

                <div class="station-name text-center text-white text-2xl m-4">
                    <p>{{$station['staName']}}</p>
                </div>

                <div class="station-image w-1/2 relative h-64 w-48">
                    <img class="rounded-3xl absolute inset-0 w-full h-full object-cover" src="{{$station['staImg']}}" alt="Image de la station de {{$station['staName']}}">    
                </div>

            </div>
            @endforeach

    </div>

</div>

@endsection