<?php


namespace Marzzelo\Graph;


class CsvFileReader extends CsvStringReader implements IReader
{
	public function __construct(string $csvFile, string $delimiter = "\t", int $skip = 0)
	{
		$csvString = file_get_contents($csvFile);

        if ($skip > 0) {
            $csvString = implode("\n", array_slice(explode("\n", $csvString), $skip));
        }

        $skip_fromArray = $skip >= 0 ? 0 : -1;
		parent::__construct($csvString, $delimiter, $skip_fromArray);
	}
}
