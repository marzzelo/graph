<?php

use Illuminate\Support\Facades\Route;
use Marzzelo\Graph\Http\Controllers\GraphController;

Route::get(config('graph.test-route'), [GraphController::class, 'index']);
