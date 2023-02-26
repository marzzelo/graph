<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;
use Intervention\Image\Facades\Image as FImage;

class Frame implements IFrame
{
	private array $options;

	private ?Image $canvas = null;


	public function __construct(array $options)
	{
		$this->options = $options;

		$width_px = $options['width-px'] ?? 640;
		$height_px = $options['height-px'] ?? 480;
		$background_color = $options['background-color'] ?? '#FFE';
		$frame_color = $options['frame-color'] ?? '#bbb';

		$this->canvas = FImage::canvas($width_px, $height_px, $background_color)
		                ->rectangle(0,
			                0,
			                $width_px - 1,
			                $height_px - 1,
			                function ($draw) use ($frame_color) {
				                $draw->border(1, $frame_color);
			                }
		                );

	}

	public function getCanvas(): Image
	{
		return $this->canvas;
	}

	public function getOptions(): array
	{
		return $this->options;
	}
}
