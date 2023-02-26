<?php

return [
	'test-route' => 'graph-test',

	'default-options' => [
		'frame' => [
			'width-px'         => 640,
			'height-px'        => 480,
			'background-color' => '#CDE',
			'frame-color'      => '#357435',
		],

		'axis' => [
			'grid-size-xy'           => [null, null],
			'labels'                 => [null, null],
			'margin'                 => 5, // can be array [x, y] or int
			'title'                  => '',
			'title-color'            => null,  // takes a contrasting color from 'background-color'
			'title-background-color' => null,  // takes 'background-color' darken by 20%
			'axis-color'             => '#555', // color of axis lines
			'grid-color'             => '#FFF',
			'labels-color'           => '#777',
		],

		'datasets' => [[
			'line-color'    => '#00A',
			'marker-radius' => 0,
			'marker-color'  => '#00A',
		]],

		'csv'  => [
			'delimiter' => ',',
			'skip'      => 0,
		],
		'test' => 'Eureka!',
	],
];
