<?php declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

interface IDataSet
{
	public function draw(IAxis $axis): Image;

	public function xBounds(): array;

	public function yBounds(): array;

	public function width(): float;

	public function height(): float;
}