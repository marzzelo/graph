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
			return new Graph(...$params);
		});

		$this->app->bind('frame', function ($app, $params) {
			return new Frame(...$params);
		});

		$this->app->bind('dataSet', function ($app, $params) {
			return new DataSet(...$params);
		});

		$this->app->bind('autoAxis', function ($app, $params) {
			// $frame = $this->app->make('frame'); // instanciates a Frame object with default values
			return new AutoAxis(...$params);
		});

		$this->app->bind('basicAxis', function ($app, $params) {
			// $frame = $this->app->make('frame'); // instanciates a Frame object with default values
			return new BasicAxis(...$params);
		});
	}

	public function boot() {
		// boot() se ejecuta al finalizar el registro de todos los Service Providers.
	}
}
