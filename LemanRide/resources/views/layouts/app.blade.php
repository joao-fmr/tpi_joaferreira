<!DOCTYPE html>
<html lang="en" data-theme="corporate">
    <head>
        <!-- 
            Author : João Ferreira 
            Date : 30.05.2023
            Description :
        -->

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Import the css file -->
        @vite('resources/css/app.css')

        <!-- Import Echarts Apache library -->
        <script src="https://cdn.jsdelivr.net/npm/echarts@latest"></script>

        <title>LemanRide</title>

        <link rel="icon" href="{{asset('img/lemanride-logo.png')}}"/>

    </head>

    <body class="bg-fixed bg-center" style="background-image: url(' <?php echo asset('img/background/leman-lake-1.jpg') ?> ')">
        <!-- Header -->
        @include('partials/navbar')

        @yield('content')
        
        <!-- Footer -->
        @include('partials/footer')
    </body>
    
</html>