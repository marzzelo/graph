<?php


namespace Marzzelo\Graph;


class CsvFileReader extends CsvStringReader implements IReader
{
	public function __construct(string $csvFile, string $delimiter = "\t", bool $hasHeaders = true)
	{
		$csvString = file_get_contents($csvFile);
		parent::__construct($csvString, $delimiter, $hasHeaders);
	}
}