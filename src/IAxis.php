<?php


namespace Marzzelo\Graph;


use Intervention\Image\Image;

interface IAxis
{
	public function xmin(): float;

	public function xmax(): float;

	public function ymin(): float;

	public function ymax(): float;

	public function draw(Image $canvas, int $width_px, int $height_px): Image;
}