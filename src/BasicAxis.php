<?php


namespace Marzzelo\Graph;

use Intervention\Image\Image;

class BasicAxis implements IAxis
{
	public float $xmin;

	public float $xmax;

	public float $ymin;

	public float $ymax;

	protected string $title = '', $xlabel = '', $ylabel = '';

	protected float $stepx = 0, $stepy = 0;

	protected float $w, $h;

	/**
	 * basicAxis constructor.
	 * @param float $margin Margin percentage
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

	public function addLabels(array $labels)
	{
		$this->xlabel = $labels[0];
		$this->ylabel = $labels[1];
	}

	public function setGrid(float $stepx, float $stepy)
	{
		$this->stepx = $stepx;
		$this->stepy = $stepy;
	}

	public function draw(Image $canvas, int $width_px, int $height_px): Image
	{
		$this->w = $width_px;
		$this->h = $height_px;

		[$CX, $CY] = $this->XY(0, 0);

		$sx = $this->stepx ?: ($this->xmax - $this->xmin) / 5;
		$nmin = floor($this->xmin / $sx);
		$nsteps = ($this->xmax - $this->xmin) / $sx;

		// X-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY($i * $sx, 0);
			$canvas->line($xn, 0, $xn, $height_px, function ($draw) {
				$draw->color = '#DDD';
			});
			$canvas->text($i * $sx, $xn, $yn - 3);
		}

		$sy = $this->stepy ?: ($this->ymax - $this->ymin) / 5;
		$nmin = floor($this->ymin / $sy);
		$nsteps = ($this->ymax - $this->ymin) / $sy;

		// Y-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY(0, $i * $sy);
			$canvas->line(0, $yn, $width_px, $yn, function ($draw) {
				$draw->color = '#DDD';
			});
			$canvas->text($i * $sy, $xn + 3, $yn);
		}

		// XY-AXIS
		$canvas->line($CX, 0, $CX, $height_px, function ($draw) {
			$draw->color('#555');
		})
		       ->line(0, $CY, $width_px, $CY, function ($draw) {
			       $draw->color('#555');
		       });

		// TITLE
		if ($this->title) {
			$canvas->rectangle(0, 0, $this->w - 1, 18, function ($draw) {
				$draw->background('rgba(255, 255, 255, 0.8)');
				$draw->border(1,'rgba(128, 128, 128, 0.8)');
			});
			$canvas->text($this->title, $this->w / 2, 5, function ($font) {
				$font->file(5);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
		}

		// X-LABEL
		if ($this->xlabel) {
			$canvas->text($this->xlabel, $this->w - 10, $this->XY(0, 0)[1] + 3, function ($font) {
				$font->file(2);
				$font->color('#000');
				$font->align('right');
				$font->valign('top');
			});
		}

		// Y-LABEL
		if ($this->ylabel) {
			$canvas->text($this->ylabel, $this->XY(0, 0)[0] + 3, 24, function ($font) {
				$font->file(2);
				$font->color('#000');
				$font->align('left');
				$font->valign('top');
			});
		}

		return $canvas;
	}

	public function XY(float $x, float $y): array
	{
		$X = intval($this->w * ($x - $this->xmin) / ($this->xmax - $this->xmin));
		$Y = intval($this->h * ($this->ymax - $y) / ($this->ymax - $this->ymin));

		return [$X, $Y];
	}

}