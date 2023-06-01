<!DOCTYPE html>
<html lang="en" data-theme="corporate">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- Import Echarts Apache -->
    <script src="https://cdn.jsdelivr.net/npm/echarts@latest"></script>

    <title>LemanRide</title>

</head>
<body class="bg-fixed bg-center" style="background-image: url(' <?php echo asset('img/background/leman-lake-1.jpg') ?> ')">

    @include('partials/navbar')
    @yield('content')
    @include('partials/footer')
</body>
   
</html>