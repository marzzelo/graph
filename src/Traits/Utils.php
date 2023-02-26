<?php

namespace Marzzelo\Graph\Traits;

trait Utils
{
	function roundToFirstDigit(float $number): int
	{
		// round to integer
		$number = round($number);

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

	/**
	 * Given a color in the format #RRGGBB, returns darker or lighter color in the same format
	 *
	 * @param  string  $hex  Color in the format #RRGGBB or #RGB
	 * @returns string Color in the format #RRGGBB
	 */
	function colorLuminance(string $hex, float $percent): string
	{
		// validate hex string
		[$hex, $new_hex] = $this->validateHexString($hex);

		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = hexdec(substr($hex, $i * 2, 2));
			$dec = min(max(0, $dec + $dec * $percent), 255);
			$new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
		}

		return $new_hex;
	}

	/**
	 * Given a color in the format #RRGGBB, returns a high contrasting color in the same format
	 *
	 * @param  string  $hex  Color in the format #RRGGBB or #RGB
	 * @returns string Color in the format #RRGGBB
	 */
	function colorContrast(string $hex): string
	{
		[$hex, $new_hex] = $this->validateHexString($hex);

		// convert to decimal and change luminosity
		for ($i = 0; $i < 3; $i++) {
			$dec = hexdec(substr($hex, $i * 2, 2));
			$dec = min(max(0, $dec + $dec * 0.5), 255);
			$new_hex .= str_pad(dechex($dec), 2, 0, STR_PAD_LEFT);
		}

		return $new_hex;
	}



	function getContrastingColor(string $color): string
	{
		[$color,] = $this->validateHexString($color);
		$color = '#' . $color;

		$r = hexdec(substr($color, 1, 2));
		$g = hexdec(substr($color, 3, 2));
		$b = hexdec(substr($color, 5, 2));
		$brightness = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
		if ($brightness > 128) {
			return '#000000'; // black
		}
		else {
			return '#FFFFFF'; // white
		}
	}

	/**
	 * @param  string  $hex
	 * @return array
	 */
	private function validateHexString(string $hex): array
	{
		// validate hex string
		$hex = preg_replace('/[^0-9a-f]/i', '', $hex);  // remove any non-hex characters
		$new_hex = '#';

		if (strlen($hex) < 6) {
			$hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
		}
		return [$hex, $new_hex];
	}

}
