<?php

namespace Marzzelo\Graph\Providers;

use Marzzelo\Graph\Graph;
use Illuminate\Support\ServiceProvider;

class GraphServiceProvider extends ServiceProvider
{

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register(): void
	{
		// load configuration file
		$this->mergeConfigFrom(__DIR__ . '/../../config/graph.php', 'graph');

		// register the graph service
		$this->app->bind('graph', function ($app, $params) {
			return new Graph(...$params);
		});
	}

	public function boot()
	{
		// boot() se ejecuta al finalizar el registro de todos los Service Providers.
		// Se ejecuta antes de que se resuelvan las rutas, middleware, vistas, comandos, etc.

		// cargar rutas del paquete
		$this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

		// cargar vistas del paquete
		$this->loadViewsFrom(__DIR__ . '/../../resources/views', 'graph');

	}
}
