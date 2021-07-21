<?php declare(strict_types=1);


namespace Marzzelo\Graph;


use Intervention\Image\Image;

class DataSet implements IDataSet
{
	private array $data;

	private int $radius;

	private string $color;

	public function __construct(array $data, int $radius, string $color)
	{
		$this->data = $data;
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

	public function draw(Image &$canvas, IAxis $axis): Image
	{
		$W = $canvas->width();
		$H = $canvas->height();

		[$X0, $Y0] = $this->XY($this->data[0][0], $this->data[0][1], $W, $H, $axis);

		foreach ($this->data as $xy) {
			[$X, $Y] = $this->XY($xy[0], $xy[1], $W, $H, $axis);

			$canvas->line($X0,
				$Y0,
				$X,
				$Y,
				function ($draw) {
					$draw->color($this->color);
				});
			$canvas->circle($this->radius,
				$X,
				$Y,
				function ($draw) {
					$draw->background($this->color);
				});
			[$X0, $Y0] = [$X, $Y];
		}

		return $canvas;
	}

	protected function XY(float $x, float $y, int $W, int $H, IAxis $axis): array
	{
		$X = (float)$W * ($x - $axis->xmin()) / ($axis->xmax() - $axis->xmin());
		$Y = (float)$H * ($axis->ymax() - $y) / ($axis->ymax() - $axis->ymin());

		return [$X, $Y];
	}
}