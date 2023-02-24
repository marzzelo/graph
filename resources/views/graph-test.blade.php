<x-graph::layout>
	<x-slot name="title">
		{{ $title ?? 'Marzzelo/Graph Package Test' }}
	</x-slot>
	
	<x-slot name="header">
		<h3>
		{{ $headerText ?? 'Marzzelo/Graph Package Test' }}
		</h3>
	</x-slot>
	
	{{-- MAIN SECTION --}}
	<pre>{!!$message!!}</pre>
	
	{{-- GRAPH SECTION --}}
	<div class=''>
		<h3>Graph 1: From Memory Array</h3>
		{{-- <img src="{{$graph1}}" alt='' class='' /> --}}
	</div>
	
	<div class=''>
		<h3>Graph 2: From CSV File</h3>
		{{-- <img src="{{$graph2}}" alt='' class='' /> --}}
	</div>
</x-graph::layout>
