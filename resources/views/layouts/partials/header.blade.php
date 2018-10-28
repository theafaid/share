<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<!-- meta character set -->
<meta charset="UTF-8">
<!-- Meta Description -->
<meta name="description" content="Share is a simple knowledge sharing through information, skills, or expertise.">
<!-- Meta CSRF_TOKENS -->
<meta name="csrf-token" content="{{csrf_token()}}">
<!-- Mobile Specific Meta -->
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicon-->
<link rel="icon" href="{{asset('design')}}/img/fav.png">
<!-- Author Meta -->
<meta name="author" content="Abdulrahman Faid">
<!-- Meta Description -->
<meta name="description" content="">
<!-- Meta Keyword -->
<meta name="keywords" content="share,knowledge,learn,education,threads,channels,subscribe,experince">
<!-- Site Title -->
<title>@yield('title', 'Welcome To Share')</title>

<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
	<!--
	CSS
	============================================= -->
	<link rel="stylesheet" href="{{asset('design')}}/css/linearicons.css">
	<link rel="stylesheet" href="{{asset('design')}}/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('design')}}/css/bootstrap.css">
	<link rel="stylesheet" href="{{asset('design')}}/css/owl.carousel.css">
	<link rel="stylesheet" href="{{asset('design')}}/css/main.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<style>
		*, body{
			font-family: 'Open Sans', sans-serif;
		}
	</style>

	<script>
		user = {!! json_encode([
			'id' => auth()->user() ? auth()->user()->id : null
			]) !!}

	</script>
</head>
<body>
