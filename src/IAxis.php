<?php
declare(strict_types=1);


namespace Marzzelo\Graph;


use Intervention\Image\Image;

interface IAxis
{
	public function xmin(): float;

	public function xmax(): float;

	public function ymin(): float;

	public function ymax(): float;

	public function draw(Image &$canvas): Image;

	public function setGrid(float $stepx, float $stepy): void;

	public function addLabels(array $labels): void;
}