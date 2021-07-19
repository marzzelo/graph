<?php

namespace Marzzelo\Graph;

use Intervention\Image\Image;

interface IFrame
{
	public function getCanvas(): Image;
}