<?php


namespace Marzzelo\Graph;


class XYPoint
{
	public float $x;

	public float $y;

	public function __construct(float $x, float $y)
	{
		$this->x = $x;
		$this->y = $y;
	}
}