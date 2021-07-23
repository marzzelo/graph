<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class BasicAxis implements IAxis
{
	private float $_xmin;

	private float $_xmax;

	private float $_ymin;

	private float $_ymax;

	private Image $canvas;

	protected string $title = '', $xlabel = '', $ylabel = '';

	protected float $stepx = 0, $stepy = 0;

	/**
	 * basicAxis constructor.
	 * @param float $margin Margin percentage
	 */
	// public function __construct(XYPoint $ul, XYPoint $lr, float $margin = 20, string $title = '')
	public function __construct(float $xm, float $xM, float $ym, float $yM, Image &$canvas, float $margin = 20)
	{
		if (($xm == $xM) || ($ym == $yM)) {
			// dd($xm, $xM, $ym, $yM);
			throw new \InvalidArgumentException('WIDTH OR HEIGHT CAN NOT BE ZERO');
		}

		$dx = abs($xM - $xm);
		$dy = abs($yM - $ym);

		$this->_xmin = $xm - $margin / 100 * $dx;
		$this->_xmax = $xM + $margin / 100 * $dx;
		$this->_ymin = $ym - $margin / 100 * $dy;
		$this->_ymax = $yM + $margin / 100 * $dy;

		$this->canvas = $canvas;
	}

	public function addLabels(string $labelx, string $labely, string $title = ''): self
	{
		$this->xlabel = $labelx;
		$this->ylabel = $labely;
		$this->title = $title;
		return $this;
	}

	public function setGrid(float $stepx, float $stepy): self
	{
		$this->stepx = $stepx;
		$this->stepy = $stepy;
		return $this;
	}

	public function draw(): Image
	{
		$W = $this->canvas->width();
		$H = $this->canvas->height();

		[$CX, $CY] = $this->XY(0, 0);

		$sx = $this->stepx
			?: ($this->_xmax - $this->_xmin) / 5;
		$nmin = floor($this->_xmin / $sx);
		$nsteps = ($this->_xmax - $this->_xmin) / $sx;

		// X-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY($i * $sx, 0);
			$this->canvas->line($xn, 0, $xn, $H, function ($draw) {
				$draw->color = '#DDD';
			});
			$format = (abs($i * $sx) < 10)
				? '%.2f'
				: '%.0f';
			$this->canvas->text(sprintf($format, $i * $sx), $xn, $yn - 3);
		}

		$sy = $this->stepy
			?: ($this->_ymax - $this->_ymin) / 5;
		$nmin = floor($this->_ymin / $sy);
		$nsteps = ($this->_ymax - $this->_ymin) / $sy;

		// Y-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY(0, $i * $sy);
			$this->canvas->line(0, $yn, $W, $yn, function ($draw) {
				$draw->color = '#DDD';
			});
			$format = (abs($i * $sy) < 10)
				? '%.2f'
				: '%.0f';
			$this->canvas->text(sprintf($format, $i * $sy), $xn + 3, $yn);
		}

		// XY-AXIS
		$this->canvas->line($CX, 0, $CX, $H, function ($draw) {
			$draw->color('#555');
		})
		       ->line(0, $CY, $W, $CY, function ($draw) {
			       $draw->color('#555');
		       });

		// TITLE
		if ($this->title) {
			$this->canvas->rectangle(0, 0, $W - 1, 18, function ($draw) {
				$draw->background('rgba(255, 255, 255, 0.8)');
				$draw->border(1, 'rgba(128, 128, 128, 0.8)');
			});
			$this->canvas->text($this->title, $W / 2, 5, function ($font) {
				$font->file(5);
				$font->color('#000');
				$font->align('center');
				$font->valign('top');
			});
		}

		// X-LABEL
		if ($this->xlabel) {
			$this->canvas->text($this->xlabel, $W - 10, $this->XY(0, 0)[1] + 3, function ($font) {
				$font->file(2);
				$font->color('#000');
				$font->align('right');
				$font->valign('top');
			});
		}

		// Y-LABEL
		if ($this->ylabel) {
			$this->canvas->text($this->ylabel, $this->XY(0, 0)[0] + 3, 24, function ($font) {
				$font->file(2);
				$font->color('#000');
				$font->align('left');
				$font->valign('top');
			});
		}

		return $this->canvas;
	}

	public function XY(float $x, float $y): array
	{
		$X = intval($this->canvas->width() * ($x - $this->_xmin) / ($this->_xmax - $this->_xmin));
		$Y = intval($this->canvas->height() * ($this->_ymax - $y) / ($this->_ymax - $this->_ymin));
		return [$X, $Y];
	}

	public function xmin(): float
	{
		return $this->_xmin;
	}

	public function xmax(): float
	{
		return $this->_xmax;
	}

	public function ymin(): float
	{
		return $this->_ymin;
	}

	public function ymax(): float
	{
		return $this->_ymax;
	}

	// public function getWidth(): int
	// {
	// 	return $this->canvas->width();
	// }
	//
	// public function getHeight(): int
	// {
	// 	return $this->canvas->height();
	// }
	public function getCanvas(): Image
	{
		return $this->canvas;
	}
}