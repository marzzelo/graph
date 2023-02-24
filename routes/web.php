<?php

use Illuminate\Support\Facades\Route;
use Marzzelo\Graph\Http\Controllers\GraphController;

Route::get('graph', [GraphController::class, 'index']);