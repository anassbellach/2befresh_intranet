<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://www.2befresh.nl/wp-content/uploads/2022/11/cropped-2BeFresh-favicon-270x270.png">


    <title>Intranet 2BeFresh</title>
    @routes
    @vite('resources/js/app.js')
    @inertiaHead
</head>
    <body>
        @inertia
{{--        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGt53_sxryMkf5PmuUSoPZ5xzWswB_5Rk&libraries=places&v=weekly&callback=initMap" async defer></script>--}}
        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGt53_sxryMkf5PmuUSoPZ5xzWswB_5Rk&libraries=places&v=weekly&callback=initMap"
            async
            defer
        ></script>

    </body>
</html>
