<?php


namespace Marzzelo\Graph;


use Intervention\Image\Image;

interface IAxis
{
	public function draw(Image $canvas, int $width_px, int $height_px): Image;
}