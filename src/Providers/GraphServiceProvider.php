<?php

namespace Marzzelo\Graph\Providers;

use Illuminate\Support\Facades\Blade;
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
		$this->mergeConfigFrom($this->basePath('config/graph.php'), 'graph');

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
		$this->loadRoutesFrom($this->basePath('routes/web.php'));

		// cargar vistas del paquete
		$this->loadViewsFrom($this->basePath('resources/views'), 'graph');

        // registrar vistas para vendor:publish
        $this->publishes([
            $this->basePath('resources/views') => resource_path('views/vendor/graph'),
        ], 'marzzelo:graph-views');

        // registrar configuración para vendor:publish
        $this->publishes([
            $this->basePath('config/graph.php') => config_path('graph.php'),
        ], 'marzzelo:graph-config');

        // cargar componentes de Blade
        Blade::componentNamespace('Graph\\Views\\Components', 'graph');

	}

    private function basePath(string $path): string
    {
        return __DIR__ . '/../../' . $path;
    }
}
