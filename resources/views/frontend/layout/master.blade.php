<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IssueMonitoring</title>

    <link type="text/css" rel="stylesheet" href="{{ elixir('css/main.css') }}" media="all">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">
        @include('frontend.layouts.partials.header')

        <div id="page-wrapper">
            @yield('content')
        </div>

        @include('frontend.layouts.partials.footer')        
    </div>

    <!-- Bootstrap Core CSS -->
    <script> var CKEDITOR_BASEPATH = '/build/js/ckeditor/'</script>
    <script src="{{ elixir('js/main.js') }}"></script>
    @yield('js')
</body>
</html>
