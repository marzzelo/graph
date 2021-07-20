<?php

namespace Marzzelo\Graph;

use Intervention\Image\Image;

interface IFrame
{
	public function getHeight(): int;

	public function getWidth(): int;

	public function getCanvas(): Image;
}