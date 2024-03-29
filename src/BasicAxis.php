<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;
use InvalidArgumentException;
use Marzzelo\Graph\Traits\Utils;

/**
 *
 */
class BasicAxis implements IAxis
{
	use Utils;

	private float $_xmin;

	private float $_xmax;

	private float $_ymin;

	private float $_ymax;

	private Image $canvas;

	private IFrame $frame;

	protected ?string $title = '', $xlabel = '', $ylabel = '';

	protected ?float $stepx = null, $stepy = null;

	protected array $options = [];


	/**
	 * @param  float                  $xm     X min
	 * @param  float                  $xM     X max
	 * @param  float                  $ym     Y min
	 * @param  float                  $yM     Y max
	 * @param  \Marzzelo\Graph\IFrame  $frame  IFrame implementing object
	 * @param  array                  $options
	 */
	public function __construct(float $xm, float $xM, float $ym, float $yM, IFrame $frame, array $options = [])
	{
		$this->options = $options;

		$this->frame = $frame;

		if (($xm == $xM) || ($ym == $yM)) {
			throw new InvalidArgumentException('WIDTH OR HEIGHT CAN NOT BE ZERO');
		}

		$dx = abs($xM - $xm);
		$dy = abs($yM - $ym);

		if (is_array($options["margin"] ?? null)) {
			[$xmargin, $ymargin] = $options["margin"];
		}
		else {
			$xmargin = $ymargin = $options["margin"] ?? 20;
		}

		$this->_xmin = $xm - $xmargin / 100 * $dx;
		$this->_xmax = $xM + $xmargin / 100 * $dx;
		$this->_ymin = $ym - $ymargin / 100 * $dy;
		$this->_ymax = $yM + $ymargin / 100 * $dy;

		$this->xlabel = $options["labels"][0] ?? '';
		$this->ylabel = $options["labels"][1] ?? '';

		$this->title = $options["title"] ?? '';

		$this->stepx = $options["grid-size-xy"][0] ?? null;
		$this->stepy = $options["grid-size-xy"][1] ?? null;

		$this->canvas = $frame->getCanvas();
	}

	public function draw(): Image
	{
		// dd($this->roundToFirstDigit(16));

		$canvas = $this->canvas;
		$W = $canvas->width();
		$H = $canvas->height();

		[$CX, $CY] = $this->XY(0, 0);

		$sx = $this->stepx
			?: ($this->_xmax - $this->_xmin) / 5;
			// ?: $this->roundToFirstDigit(($this->_xmax - $this->_xmin) / 5);
		$nmin = floor($this->_xmin / $sx);
		$nsteps = ($this->_xmax - $this->_xmin) / $sx;

		// X-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY($i * $sx, 0);
			$canvas->line($xn, 0, $xn, $H, function ($draw) {
				$draw->color = $this->options["grid-color"] ?? '#DDD';
			});
			$format = (abs($i * $sx) < 10)
				? '%.2f'
				: '%.0f';
			$canvas->text(sprintf($format, $i * $sx), $xn + 3, $yn + 10);
		}

		$sy = $this->stepy
			?: ($this->_ymax - $this->_ymin) / 5;
			// ?: $this->roundToFirstDigit(($this->_ymax - $this->_ymin) / 5);
		$nmin = floor($this->_ymin / $sy);
		$nsteps = ($this->_ymax - $this->_ymin) / $sy;

		// Y-GRID
		for ($i = $nmin; $i < $nsteps; $i++) {
			[$xn, $yn] = $this->XY(0, $i * $sy);
			$canvas->line(0, $yn, $W, $yn, function ($draw) {
				$draw->color = $this->options["grid-color"] ?? '#DDD';
			});
			$format = (abs($i * $sy) < 10)
				? '%.2f'
				: '%.0f';
			if ($i != 0)
				$canvas->text(sprintf($format, $i * $sy), (int) $xn - 5, $yn, function ($font) {
					$font->align('right');
				});
		}

		// XY-AXIS
		$canvas->line($CX, 0, $CX, $H, function ($draw) {
			$draw->color($this->options['axis-color'] ?? '#555');
		})
		       ->line(0, $CY, $W, $CY, function ($draw) {
			       $draw->color($this->options['axis-color'] ?? '#555');
		       });

		// TITLE
		if ($this->title) {
			$frame_bgcolor = $this->frame->getOptions()['background-color'] ?? '#FFF';
			$default_bgcolor = $this->colorLuminance($frame_bgcolor, -0.2);
			$bgcolor = $this->options['title-bgcolor'] ?? $default_bgcolor;

			$text_color = $this->options['title-color'] ?? '#000';
			$default_text_color = $this->getContrastingColor($bgcolor);
			$tcolor = $this->options['title-color'] ?? $default_text_color;

			$canvas->rectangle(0, 0, $W - 1, 18, function ($draw) use ($bgcolor) {
				$draw->background($bgcolor);  // opacity could be 0.8
				$draw->border(1, $this->frame->getOptions()['frame-color'] ?? '#555');
			});

			$canvas->text($this->title, $W / 2, 5, function ($font) use ($tcolor) {
				$font->file(5);
				$font->color($tcolor);
				$font->align('center');
				$font->valign('top');
			});
		}

		// X-LABEL
		// @formatter:off
		if ($this->xlabel) {
			$canvas->text(
				$this->xlabel,
				$W - 10,
				(int) Graph::confineTo($this->XY(0, 0)[1] - 5, 0,  $this->canvas->height() - 20),
				function ($font) {
						$font->file(2);
						$font->color($this->options['labels-color'] ?? '#000');
						$font->align('right');
						$font->valign('bottom');
				});
		}

		// Y-LABEL
		if ($this->ylabel) {
			$canvas->text(
				$this->ylabel,
				(int)Graph::confineTo($this->XY(0, 0)[0] + 10, 30, $this->canvas->width() - 50),
				24,
				function ($font) {
					$font->file(2);
					$font->color($this->options['labels-color'] ?? '#000');
					$font->align('left');
					$font->valign('top');
				});
		}
		// @formatter:on

		return $canvas;
	}

	/**
	 * This function returns the coordinates of the point (x,y) in the canvas coordinate system.
	 * @param  float  $x
	 * @param  float  $y
	 * @return array
	 */
	public function XY(float $x, float $y): array
	{
		$W = $this->canvas->width();
		$H = $this->canvas->height();

		$X = intval($W * ($x - $this->_xmin) / ($this->_xmax - $this->_xmin));
		$Y = intval($H * ($this->_ymax - $y) / ($this->_ymax - $this->_ymin));
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

	public function getCanvas(): Image
	{
		return $this->canvas;
	}

	/**
	 * @param  string  $labelx
	 * @param  string  $labely
	 * @return \Marzzelo\Graph\BasicAxis
	 */
	public function setLabels(?string $labelx, ?string $labely): self  {
        $this->xlabel = $labelx ?? $this->xlabel;
        $this->ylabel = $labely ?? $this->ylabel;
        return $this;
	}
}
