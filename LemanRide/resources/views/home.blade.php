@extends('layouts.app')
@section('content')

<div class="titles text-center text-white font-bold p-10">
    <h1 class="title lg:text-6xl text-4xl mb-5">LemanRide</h1>
    <h2 class="subtitle lg:text-xl text-lg">Votre guide en temps réel pour une navigation en toute sécurité !</h2>
</div>


<div class="latest bg-gray-300 bg-opacity-80 p-4 rounded-md flex mx-auto w-5/6 lg:w-1/3 text-[#134563] font-bold text-lg lg:text-3xl text-center justify-between mb-10">
    
    <div class="direction flex flex-col">

        <div class="direction-text mb-2 lg:mb-10">
            <p class="">Direction</p>
        </div>

        <div class="direction-compass flex justify-center">
            <img class="w-20 lg:w-40" src="{{ $data['compass'] }}" alt="Image de boussole définisssant la direction du vent actuelle">
        </div>

        <div class="direction-type mt:2 lg:mt-10">
            <p class="">{{$data['name']}}</p>
        </div>

    </div>

    <div class="strength flex flex-col">

        <div class="strength-knots">
            <p class="">{{$data['windStrength']}} / {{$data['gustStrength']}} noeuds</p>
        </div>

        <div class="border-r-4 border-[#134563]"></div>
        
        <div class="strength-indicator">
            <!-- the double exclamation mark !! !! allows the tags <img> to be displayed correctly -->
            {!! $data['strengthStars'] !!}
        </div>

    </div>





</div>

  
    

 

           
        





<div class="flex justify-center bg-gray-300 bg-opacity-80 p-4 rounded-md mb-10 ml-5 mr-5">
    <div id="graph" style="width:100%;height:400px"></div>
</div>

<script type="text/javascript">
    let allData = <?php echo json_encode($graphData); ?>
</script>

@vite('resources/js/graph.js')

@endsection