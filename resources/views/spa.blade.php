<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <link href="{{asset('css/shared_style.css')}}" rel="stylesheet">
    <title>هندسة المعلوماتية</title>
</head>

<body>
    <div id="application" style="direction: rtl;">
        <app></app>
    </div>
    <script src="{{ mix('js/app.js') }}">  </script>
</body>

</html>