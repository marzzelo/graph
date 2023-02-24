<?php

namespace Marzzelo\Graph\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class GraphController extends Controller
{
	public function index(): Factory|View|Application
	{
        $items = config('graph');
        $message = print_r($items, true);

		return view('graph::graph-test', [
			'message' => $message
		]);
	}
}
