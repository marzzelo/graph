<?php

use Illuminate\Support\Facades\Route;
use Marzzelo\Graph\Facades\Graph as FGraph;

Route::get('graph', function () {
	return FGraph::hello('Route');
});