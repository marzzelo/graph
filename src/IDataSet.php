<?php

namespace Marzzelo\Graph;

use Intervention\Image\Image;

interface IDataSet
{
	public function draw(Image $canvas, IAxis $axis, int $width, int $height);
}