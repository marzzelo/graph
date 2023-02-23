<?php

return [
    'frame'   => [
        'width_px'         => 640,
        'height_px'        => 400,
        'background_color' => '#FFE',
        'frame_color'      => '#bbb',
    ],

    'axis'    => [
        'grid-size-xy'     => [null, null],
        'labels'           => [null, null],
        'margin'           => 20, // can be array [x, y] or int
        'title'            => '',
        'title-color'      => '#000',
        'axis-color'       => '#555', // color of axis lines
        'grid-color'       => '#ddd',
        'background-color' => '#fff',
        'labels-color'     => '#555',
    ],

    'dataset' => [
        'line-color'    => '#00A',
        'marker-radius' => 0,
        'marker-color'  => '#00A',
    ],

    'csv'     => [
        'delimiter' => ',',
        'skip'      => 0,
    ],

];
