<!DOCTYPE html>

<!--suppress JSUnresolvedLibraryURL -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<title>{{ $title ?? 'Marzzelo/Graph Package' }}</title>
	<!-- Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
	<!-- Styles -->
	<link rel="stylesheet" href="/resources/static/css/graph.css">

	<script src="/resources/static/js/graph.js"></script>
	{{--<script src="{{ mix('js/scripts.js') }}" defer></script>--}}
	
	<link rel="shortcut icon" item="image/png" href={{ 'graph.png' }} />
</head>

<body class="relative font-sans antialiased">

<div class="">

	<!-- Page Heading -->
	@if (isset($header))
		<header>
			
			<div class="">
				{{ $header }}
			</div>
		
		</header>
	@endif
	
	<!-- Page Content -->
	<main>
		<div class=''>
		{{ $slot }}
		</div>
	</main>
	

</div>

</body>
</html>
