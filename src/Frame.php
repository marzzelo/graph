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

	private ?Image $canvas = null;


	public function __construct(array $options)
	{
		$this->width_px = $options['width-px'] ?? 640;
		$this->height_px = $options['height-px'] ?? 400;
		$this->background_color = $options['background-color'] ?? '#FFE';
		$this->frame_color = $options['frame-color'] ?? '#bbb';

		$this->canvas = FImage::canvas($this->width_px, $this->height_px, $this->background_color)
		                ->rectangle(0,
			                0,
			                $this->width_px - 1,
			                $this->height_px - 1,
			                function ($draw) {
				                $draw->border(1, $this->frame_color);
			                }
		                );

	}

	public function getCanvas(): Image
	{
		return $this->canvas;
	}
}
