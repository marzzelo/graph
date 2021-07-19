<?php


namespace Marzzelo\Graph;

class AbsPoint
{
	public int $X, $Y;

	public function __construct(int $X, int $Y)
	{
		$this->X = $X;
		$this->Y = $Y;
	}
}