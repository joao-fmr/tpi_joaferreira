@extends('layouts.app')
@section('content')
<!-- About page -->

<!-- Title and subtitle -->
<div class="titles text-center text-white font-bold pb-5">
    <h1 class="title lg:text-6xl text-4xl mb-5 pt-10">LemanRide</h1>
    <h2 class="subtitle lg:text-xl text-lg">Votre guide en temps réel pour une navigation en toute sécurité !</h2>
</div>

<!-- Links that go to bottom of the page  -->
<div class="sections flex flex-col lg:flex-row p-4 justify-center text-center text-white font-bold text-2xl">

    <div class="section-description mb-3 lg:m-10 lg:mr-20 flex justify-center">

        <a href="#description">
            <div class="section-description-image w-1/2 relative h-64 w-48 lg:h-96 lg:w-64 transform transition duration-500 hover:scale-110">
                <img class="rounded-full absolute inset-0 w-full h-full object-cover" src="{{asset('img/background/surf.jpg')}}" alt="">

                <div class="section-description-title absolute inset-0 flex items-center justify-center">
                    <p>Description</p>
                </div>

            </div>
        </a>

    </div>

    <div class="section-data mt-3 lg:m-10 lg:ml-20 flex justify-center">

        <a href="#data">
            <div class="section-data-image w-1/2 relative h-64 w-48 lg:h-96 lg:w-64 transform transition duration-500 hover:scale-110">
                <img class="rounded-full absolute inset-0 w-full h-full object-cover" src="{{asset('img/background/wind.jpg')}}" alt="">

                <div class="section-data-title absolute inset-0 flex items-center justify-center">
                    <p>Données</p>
                </div>

            </div>
        </a>

    </div>

</div>


<!-- Description of the project -->
<div id="description" class="bg-fixed bg-cover p-10" style="background-image: url('<?php echo asset('img/background/leman-lake-2.jpg') ?>')">

    <div class="description text-white lg:m-40">
        <h3 class="font-bold text-xl lg:text-3xl text-center mb-10">Qu'est-ce que LemanRide ?</h3>

        <p class="text-base lg:text-xl text-justify">
            LemanRide est une application web novatrice conçue spécialement pour les passionnés de sports de glisse sur le magnifique Lac Léman. Notre objectif est de vous offrir une expérience unique en vous permettant de prendre des décisions éclairées concernant vos sessions de planche à voile, de kitesurf, de wing ou de foil.
            <br><br>
            Grâce à une combinaison astucieuse des données fournies par les balises de MétéoSuisse réparties autour du lac, LemanRide vous fournit des informations météorologiques précises en temps réel, ainsi qu'un graphique détaillé de l'évolution de la force du vent sur les dernières 24 heures, avec une possibilité de visualisation étendue jusqu'à 96 heures. Ces fonctionnalités vous permettent de mieux comprendre les tendances météorologiques et d'optimiser vos sessions de glisse en anticipant les changements de conditions.
        </p>

    </div>
</div>

<!-- Infos about the data of the project -->
<div id="data" class="bg-fixed bg-cover p-10" style="background-image: url('<?php echo asset('img/background/leman-lake-3.jpg') ?>')">

    <div class="infos text-white lg:m-40">
        <h3 class="font-bold text-xl lg:text-3xl text-center mb-10">Tendance directionnelle et force du vent</h3>

        <p class="text-base lg:text-xl text-justify">
            La tendance directionnelle est représentée par une boussole facile à comprendre. Vous pouvez visualiser instantanément l'orientation actuelle du vent par rapport aux points cardinaux tels que le nord, l'est, le sud et l'ouest. En connaissant la direction du vent, vous pouvez adapter votre itinéraire, votre équipement et votre stratégie en conséquence.
            <br><br>
            La force du vent est quantifiée à l'aide d'une échelle de notation pratique basée sur des étoiles. Chaque étoile représente un intervalle spécifique de vitesse du vent. Par exemple, si vous voyez une évaluation de "2 étoiles", cela signifie que la force du vent est comprise entre 12 et 15 nœuds. Plus le nombre d'étoiles est élevé, plus le vent est fort et propice à la pratique de sports de glisse.
        </p>

    </div>
</div>

@endsection