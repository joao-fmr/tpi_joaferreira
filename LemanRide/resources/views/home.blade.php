@extends('layouts.app')
@section('content')
<br>
<br>
<br>
<br>
<br>
<br>
<?php var_dump($data); ?>


<div class="latest">
    <div class="direction">
        <div class="direction-compass">
            <img src="{{ $data['compass'] }}" alt="Image de boussole définisssant la direction du vent actuelle">
        </div>
        <div class="direction-name">
            <p>{{$data['name']}}</p>
        </div>
    </div>
    <div class="strength">
        <div class="strength-knots">
        
        </div>

    </div>


</div>


@endsection