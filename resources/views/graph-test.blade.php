<x-app-layout>
	<x-slot name="title">
		{{ $title ?? 'Marzzelo/Graph Package Test' }}
	</x-slot>
	
	<x-slot name="header">
		<h3>
		{{ $headerText ?? __('graph::graph.packtest') }}
		</h3>
	</x-slot>
	
	{{-- MAIN SECTION --}}
    <div class="graph-test">
	    <pre>{!!$message!!}</pre>
    </div>
	
	{{-- GRAPH SECTION --}}
	<div class=''>
		<h3>Graph 1: From Memory Array</h3>
		{{-- <img src="{{$graph1}}" alt='' class='' /> --}}
	</div>
	
	<div class=''>
		<h3>Graph 2: From CSV File</h3>
		{{-- <img src="{{$graph2}}" alt='' class='' /> --}}
	</div>
</x-app-layout>
