<?php

namespace Marzzelo\Graph\Traits;

trait Utils
{
	function roundToFirstDigit(int|float $number): int
	{
		// Get the first digit of the number
		$firstDigit = (int)substr($number, 0, 1);

		// Get the length of the number
		$length = strlen((string)$number);

		// Calculate the number of zeros to add after the first digit
		$zeros = $length - 1;

		// Create a string with the first digit followed by zeros
		$result = str_pad($firstDigit, $length, '0');

		return (int)$result;
	}

}