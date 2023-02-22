<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;
use Intervention\Image\Facades\Image as FImage;

class Frame implements IFrame
{
	private int $width_px;

	private int $height_px;

	private string $background_color;

	private string $frame_color;


	public function __construct(int $width_px = 800, int $height_px = 600, string $background_color = '#FFD',
		string $frame_color = '#BBB')
	{
		$this->width_px = $width_px;
		$this->height_px = $height_px;
		$this->background_color = $background_color;
		$this->frame_color = $frame_color;
	}

	public function getCanvas(): Image
	{
		$canvas = FImage::canvas($this->width_px, $this->height_px, $this->background_color);
		$canvas->rectangle(0,
			0,
			$this->width_px - 1,
			$this->height_px - 1,
			function ($draw) {
				$draw->border(1, $this->frame_color);
			});

		return $canvas;
	}
}
