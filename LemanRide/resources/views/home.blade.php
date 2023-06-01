@extends('layouts.app')
@section('content')
<!-- Home page -->

<!-- Title and subtitle -->
<div class="titles text-center text-white font-bold p-10">
    <h1 class="title lg:text-6xl text-4xl mb-5">LemanRide</h1>
    <h2 class="subtitle lg:text-xl text-lg">Votre guide en temps réel pour une navigation en toute sécurité !</h2>
</div>

<!-- Top gray rectangle -->
<div class="latest bg-gray-300 bg-opacity-80 p-4 rounded-md flex mx-auto w-5/6 mdlg:w-1/3 text-[#134563] font-bold text-center justify-between mb-10 flex">
    <!-- Direction infos -->
    <div class="direction flex flex-col justify-between">

        <div class="direction-text mb-2 lg:mb-10 text-lg lg:text-3xl">
            <p>Direction</p>
        </div>

        <div class="direction-compass flex justify-center">
            <img class="w-32 lg:w-40" src="{{ $latestData['compass'] }}" alt="Image de boussole définisssant la direction du vent actuelle">
        </div>

        <div class="direction-type mt:2 lg:mt-10 text-base lg:text-2xl">
            <p>{{$latestData['name']}}</p>
        </div>

    </div>

    <!-- Strength infos -->
    <div class="strength flex flex-col">    
        <div class="strength-text mb-2 lg:mb-10 text-lg lg:text-3xl">
            <p>Force</p>
        </div>

        <div class="strength-infos flex flex-col">
            <div class="strength-infos-knots mb-2 text-base lg:text-2xl">
                <p>{{$latestData['windStrength']}} / {{$latestData['gustStrength']}} noeuds</p>
            </div>
            
            <div class="strength-infos-indicator mt-10 text-base lg:text-2xl">
                <!-- the double exclamation mark !! !! allows the tags <img> to be displayed correctly -->
                {!! $latestData['strengthStars'] !!}
            </div>
        </div>
     
    </div>

</div>


<!-- Graph showing the data evolution -->
<div class="flex flex-col justify-center text-[#134563] font-bold bg-gray-300 bg-opacity-80 p-4 rounded-md mb-10 ml-10 mr-10">

    <div class="text-center mb-2 lg:mb-10 text-lg lg:text-3xl">
        <p>Évolution de la force du vent depuis les dernières {{ $lastHours }} heures</p>
    </div>
    <div id="graph" style="width:100%;height:500px"></div>

    <div class="flex justify-center items-center mb-4">
        <form action="{{ route('homeLastHours') }}" method="post">
            @csrf  
            <label for="hours" class="mr-4">Heures dans le passé :</label>
            <input type="number" id="hours" name="hours" min="1" max="96" class="rounded-lg border-gray-400 border py-2 px-4" value={{$lastHours}}>
            
            <button id="submit" class="bg-blue-500 text-white py-2 px-4 rounded-lg ml-4">Afficher le graphique</button>
        </form>
    </div>

</div>



<script type="text/javascript">
    let allData = <?php echo json_encode($graphData); ?>
</script>

@vite('resources/js/graph.js')






@endsection