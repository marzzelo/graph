<?php

namespace Marzzelo\Graph\Facades;

use Marzzelo\Graph\IAxis;
use Illuminate\Support\Facades\Facade;

class Graph extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 * @method static frame(int $width_px = 800, int $height_px = 600, string $background_color = '#FFD', string $frame_color = '#BBB')
	 * @method static dataSet(array $data, int $radius = 0, string $color = '#0AA')
	 * @method static make(IAxis $x)
	 * @throws \RuntimeException
	 */
	protected static function getFacadeAccessor(): string
	{
		return 'graph';
	}
}