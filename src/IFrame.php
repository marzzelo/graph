<?php declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

interface IFrame
{
	public function getCanvas(): Image;
}