<?php

namespace Marzzelo\Graph\Facades;

use Illuminate\Support\Facades\Facade;

class AutoAxis extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 *
	 * @throws \RuntimeException
	 */
	protected static function getFacadeAccessor(): string
	{
		return 'autoAxis';
	}
}