<?php
declare(strict_types=1);


namespace Marzzelo\Graph;

use Intervention\Image\Image;

class DataSet implements IDataSet
{
	private array $data;

	private int $radius;

	private string $color;

	public function __construct(array $data = [], int $radius = 0, string $color = '#0AA')
	{
		$this->data = $data;
		$this->radius = $radius;
		$this->color = $color;
	}

	public function setMarker(int $radius = 0, string $color = '#00A')
	{
		$this->radius = $radius;
		$this->color = $color;
	}

	public function xBounds(): array
	{
		$xdata = array_column($this->data, 0);

		return ['min' => min($xdata), 'max' => max($xdata)];
	}

	public function yBounds(): array
	{
		$ydata = array_column($this->data, 1);

		return ['min' => min($ydata), 'max' => max($ydata)];
	}

	public function width(): float
	{
		$xBounds = $this->xBounds();

		return $xBounds['max'] - $xBounds['min'];
	}

	public function height(): float
	{
		$yBounds = $this->yBounds();

		return $yBounds['max'] - $yBounds['min'];
	}

	public function draw(IAxis $axis): Image
	{
		$canvas = $axis->getCanvas();

		[$X0, $Y0] = $axis->XY($this->data[0][0], $this->data[0][1]);

		foreach ($this->data as $xy) {
			[$X, $Y] = $axis->XY($xy[0], $xy[1]);

			$canvas->line($X0, $Y0, $X, $Y, function ($draw) {
				$draw->color($this->color);
			});
			if ($this->radius) {
				$canvas->circle($this->radius, $X, $Y, function ($draw) {
					$draw->background($this->color);
				});
			}
			[$X0, $Y0] = [$X, $Y];
		}

		return $canvas;
	}
}