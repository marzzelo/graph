<?php

namespace Marzzelo\Graph\Http\Controllers;

use Marzzelo\Graph\Facades\Graph;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class GraphController extends Controller
{
	public function index(): Factory|View|Application
	{
		return view('graph::graph-test', [
			'message' => Graph::hello('Route')
		]);
	}
}