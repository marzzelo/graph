<?php


namespace Marzzelo\Graph;

use Intervention\Image\Image;

class basicAxis implements IAxis
{
	public float $xmin;

	public float $xmax;

	public float $ymin;

	public float $ymax;

	private string $title = '';

	public float $w, $h;

	/**
	 * basicAxis constructor.
	 * @param float                      $margin Margin percentage
	 */
	public function __construct(XYPoint $ul, XYPoint $lr, float $margin = 20, string $title = '')
	{
		$xm = $ul->x;
		$xM = $lr->x;
		$ym = $lr->y;
		$yM = $ul->y;

		$dx = $xM - $xm;
		$dy = $yM - $ym;

		$this->xmin = $xm - $margin / 100 * $dx;
		$this->xmax = $xM + $margin / 100 * $dx;
		$this->ymin = $ym - $margin / 100 * $dy;
		$this->ymax = $yM + $margin / 100 * $dy;

		$this->title = $title;
	}

	public function draw(Image $canvas, int $width_px, int $height_px): Image
	{
		$this->w = $width_px;
		$this->h = $height_px;

		[$CX, $CY] = $this->XY(0, 0);

		$sx = ($this->xmax - $this->xmin) / 5;
		$nmin = floor($this->xmin / $sx);
		for ($i = $nmin; $i < 5; $i++) {
			[$xn, $yn] = $this->XY($i * $sx, 0);
			$canvas->line($xn, 0, $xn, $height_px, function($draw) {
				$draw->color = '#ccc';
			});
			$canvas->text( $i * $sx, $xn, $yn - 3);
		}

		$sy = ($this->ymax - $this->ymin) / 5;
		$nmin = floor($this->ymin / $sy);
		for ($i = $nmin; $i < 5; $i++) {
			[$xn, $yn] = $this->XY(0, $i * $sy);
			$canvas->line(0, $yn,$width_px, $yn, function($draw) {
				$draw->color = '#ccc';
			});
			$canvas->text( $i * $sy, $xn + 3, $yn);
		}

		$canvas->line($CX,
			0,
			$CX,
			$height_px,
			function ($draw) {
				$draw->color('#0000FF');
			})
		              ->line(0,
			              $CY,
			              $width_px,
			              $CY,
			              function ($draw) {
				              $draw->color('#0000FF');
			              });

		if ($this->title) {
			$canvas->text($this->title, $this->w / 2, 5, function($font) {
				$font->file(5);
				$font->size('48');
				$font->color('#000000');
				$font->align('center');
				$font->valign('top');
			});
		}

		return $canvas;
	}

	private function XY(float $x, float $y): array
	{
		$X = intval($this->w * ($x - $this->xmin) / ($this->xmax - $this->xmin));
		$Y = intval($this->h * ($this->ymax - $y) / ($this->ymax - $this->ymin));

		return [$X, $Y];
	}

}