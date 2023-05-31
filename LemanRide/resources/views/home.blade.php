@extends('layouts.app')
@section('content')

<div class="titles text-center text-white font-bold p-10">
    <h1 class="title lg:text-6xl text-4xl mb-5">LemanRide</h1>
    <h2 class="subtitle lg:text-xl text-lg">Votre guide en temps réel pour une navigation en toute sécurité !</h2>
</div>


<div class="latest bg-gray-200 bg-opacity-50 p-4 rounded-md flex mx-auto w-5/6 lg:w-1/3 text-[#134563] font-bold text-lg lg:text-3xl text-center justify-between mb-10">

    <div class="direction flex flex-col ml-10">
        <p class="direction-text mb-2 lg:mb-10">Direction</p>

        <div class="direction-compass flex justify-center">
            <img class="w-1/2 lg:w-40" src="{{ $data['compass'] }}" alt="Image de boussole définisssant la direction du vent actuelle">
        </div>
    
        <p class="mt-2 lg:mt-10">{{$data['name']}}</p>
    </div>

    <div class="border-r-4 border-[#134563]"></div>

    <div class="strength flex flex-col mr-10">

        <div class="strength-knots lg:mb-2">
           <p class="mb-5">{{$data['windStrength']}} / {{$data['gustStrength']}} noeuds</p>
        </div>

        <div class="strength-indicator">
            <!-- the double exclamation mark !! !! allows the tags <img> to be displayed correctly -->
            {!! $data['strengthStars'] !!}
        </div>
    </div>

</div>


@endsection