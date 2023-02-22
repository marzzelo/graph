<?php

namespace Marzzelo\Graph\Facades;

use Illuminate\Support\Facades\Facade;

class Frame extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 * @throws \RuntimeException
	 */
	protected static function getFacadeAccessor(): string
	{
		return 'frame';
	}
}