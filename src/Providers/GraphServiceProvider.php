<?php

namespace Marzzelo\Graph\Providers;

use Closure;
use Marzzelo\Graph\Frame;
use Marzzelo\Graph\Graph;
use Marzzelo\Graph\DataSet;
use Marzzelo\Graph\AutoAxis;
use Marzzelo\Graph\BasicAxis;
use Illuminate\Support\ServiceProvider;

class GraphServiceProvider extends ServiceProvider
{

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		// register the graph service
		$this->app->bind('graph', function ($app, $params) {
			return new Graph($params["axis"]);
		});

		$this->app->bind('frame', function () {
			return new Frame(800, 600, '#FFD', '#BBB');
		});

		$this->app->bind('dataSet', function () {
			return new DataSet([],  0, '#0AA');
		});

		$this->app->bind('autoAxis', function () {
			$frame = $this->app->make('frame'); // instanciates a Frame object with default values
			return new AutoAxis([], $frame);
		});

		$this->app->bind('basicAxis', function () {
			$frame = $this->app->make('frame'); // instanciates a Frame object with default values
			return new BasicAxis(-10, 10, -10, 10, $frame);
		});
	}

	public function boot() {
		// boot() se ejecuta al finalizar el registro de todos los Service Providers.
	}
}
