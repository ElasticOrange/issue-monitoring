<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>IssueMonitoring</title>

	<link type="text/css" rel="stylesheet" href="{{ elixir('css/all.css') }}" media="all">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>

<body>

	<div id="wrapper">
		@include('admin.layouts.partials.navigation')

		<div id="page-wrapper">
			@include('admin.layouts.partials.error_messages')
			@yield('content')
		</div>
	</div>

    <!-- Bootstrap Core CSS -->
    <script> var CKEDITOR_BASEPATH = '/build/js/ckeditor/'</script>
    <script src="{{ elixir('js/all.js') }}"></script>
    <script type="text/javascript" src="/js/global.js"></script>
    @yield('js')
    @include('admin.layouts.partials.ajaxloader')
</body>
</html>
