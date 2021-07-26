<?php


namespace Marzzelo\Graph;


class Printer
{
	public static function p($msg, string $descr = '')
	{
		if ($descr) echo "<h3>$descr</h3>";
		echo '<pre>';
		print_r($msg);
		echo '</pre>';
	}
}