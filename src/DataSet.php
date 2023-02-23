<?php
declare(strict_types=1);


namespace Marzzelo\Graph;

use Intervention\Image\Image;

class DataSet implements IDataSet
{
	private array $data;

	/**
	 * @var mixed|string
	 */
	private mixed $lineColor;

	/**
	 * @var mixed|string
	 */
	private mixed $markerColor;

	/**
	 * @var int|mixed
	 */
	private mixed $markerRadius;

	public function __construct(array $data = [], array $options = [])
	{
        if (empty($data))
            throw new \InvalidArgumentException('Data is empty');
        
		$this->data = $data;
		$this->markerRadius = $options['marker-radius'] ?? 0;
		$this->markerColor = $options['marker-color'] ?? '#00A';
		$this->lineColor = $options['line-color'] ?? '#00A';
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
				$draw->color($this->lineColor);
			});
			if ($this->markerRadius) {
				$canvas->circle($this->markerRadius, $X, $Y, function ($draw) {
					$draw->background($this->markerColor);
				});
			}
			[$X0, $Y0] = [$X, $Y];
		}

		return $canvas;
	}
}
