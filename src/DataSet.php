<?php


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

	public function draw(Image $canvas, IAxis $axis, int $width, int $height)
	{
		[$X0, $Y0] = $this->XY($this->data[0][0], $this->data[0][1], $width, $height, $axis);

		foreach ($this->data as $xy) {
			[$X, $Y] = $this->XY($xy[0], $xy[1], $width, $height, $axis);

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
	}

	protected function XY(float $x, float $y, int $width, int $height, IAxis $axis): array
	{
		$X = (float)$width * ($x - $axis->xmin()) / ($axis->xmax() - $axis->xmin());
		$Y = (float)$height * ($axis->ymax() - $y) / ($axis->ymax() - $axis->ymin());

		return [$X, $Y];
	}
}