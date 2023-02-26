<?php


namespace Marzzelo\Graph;

/* SAMPLE DATA
$r = new Marzzelo\Graph\CsvStringReader("t,x,v,a\n0,0,0,1\n 1,1,2,2\n 2,6,6,3\n 3,18,12,4\n 4,40,20,5",',',true)
5,75,30,6
6,126,42,7
7,196,56,8
8,288,72,9
9,405,90,10
10,550,110,11
11,726,132,12
12,936,156,13
13,1183,182,14
14,1470,210,15
15,1800,240,16
16,2176,272,17
17,2601,306,18
18,3078,342,19
19,3610,380,20
20,4200,420,21
21,4851,462,22
22,5566,506,23
23,6348,552,24
24,7200,600,25
25,8125,650,26
26,9126,702,27
27,10206,756,28
28,11368,812,29",',')

 */

class CsvStringReader implements IReader
{
	private array $headers = [];

	/**
	 * @var DataSet[] $dataSets
	 */
	private array $dataSets = [];

    private array $data = [];


	public function __construct(string $csvString, string $delimiter = "\t", int $skip = 0)
	{
		// $this->write($csvString);

		$rows = $this->csvToArray(trim($csvString), $delimiter);

		// $this->write($rows);

		if ($skip >= 0) {
			$this->extractHeaders($rows, $skip);
		}

		// $this->write($rows, "ROWS");

		$nrows = count($rows);
		$ncols = count($rows[0]);

		// $this->write($nrows, "nrows");
		// $this->write($ncols, "ncols");

		$series = [];

		for ($r = 0; $r < $nrows; $r++) {
			for ($col = 1; $col < $ncols; $col++) {
				$series[$col-1][] = [(float)$rows[$r][0], (float)$rows[$r][$col]];
			}
		}

        $this->data = $series;  // raw data

		foreach ($series as $serie) {
			$this->dataSets[] = new DataSet($serie);
		}

	}

	public function getDataSets(): array
	{
		return $this->dataSets;
	}


	public function getHeaders(): array
	{
		return $this->headers;
	}

    public function getRawData(): array
    {
        return $this->data;
    }


	protected function csvToArray($csvString, $delimiter = ',', $lineBreak = "\n"): array
	{
		$csvArray = [];
		$rows = str_getcsv($csvString, $lineBreak); // Parses the rows. Treats the rows as a CSV with \n as a delimiter
		foreach ($rows as $row) {
			$csvArray[] = str_getcsv($row,
				$delimiter); // Parses individual rows. Now treats a row as a regular CSV with ',' as a delimiter
		}
		return $csvArray;
	}

	/**
	 * @param  array  $rows
	 * @param  int    $skip
	 */
	private function extractHeaders(array &$rows, int $skip = 0): void
	{
		// rows: [ ["labelx", "labely1", "labely2",...], [x,y1,y2...], [x,y1,y2...] ]

        // skip first $skip rows
        for ($i = 0; $i < $skip; $i++) {
            array_shift($rows);
        }

		$this->headers = array_shift($rows);
		// header: ['labelx', 'labely1', 'labely2', ...]
		
	}


}
