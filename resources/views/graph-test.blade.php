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
		{{ $message }}
	</div>
	
	<div class='ml-8'>
		{{-- GRAPH SECTION --}}
		<div class='pt-8 mx-auto'>
			<h3>Graph 1: From Memory Array</h3>
			<img src="{{ $graph1 }}" alt='' class=''/>
		</div>
		
		<div class='pt-8 mx-auto'>
			<h3>Graph 2: From CSV File</h3>
			<img src="{{ $graph2 }}" alt='' class=''/>
		</div>
	</div>
</x-app-layout>
