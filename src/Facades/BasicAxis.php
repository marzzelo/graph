<?php

namespace Marzzelo\Graph\Facades;

use Illuminate\Support\Facades\Facade;

class BasicAxis extends Facade
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
		return 'basicAxis';
	}
}