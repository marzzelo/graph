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

	// public function getWidth(): int;
	//
	// public function getHeight(): int;

	public function getCanvas(): Image;

	public function XY(float $x, float $y): array;

	public function draw(): Image;

	public function setGrid(float $stepx, float $stepy): self;

	public function addLabels(string $labelx, string $labely, string $title = ''): self;
}