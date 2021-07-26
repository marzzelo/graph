<?php
declare(strict_types=1);


namespace Marzzelo\Graph;


use Intervention\Image\Image;

class AutoAxis extends BasicAxis implements IAxis
{
	/**
	 * AutoAxis constructor.
	 * @param \Marzzelo\Graph\DataSet[] $dataSets
	 * @param float|int                 $margin Margin from canvas border to Series curves
	 */
	public function __construct(array $dataSets, Frame &$frame, float $margin = 20)
	{
		[$xm, $xM, $ym, $yM] = $this->endpoints($dataSets);

		parent::__construct($xm, $xM, $ym, $yM, $frame, $margin);
	}


	/**
	 * @param \Marzzelo\Graph\DataSet[] $dataSets
	 * @return float[]
	 */
	protected function endpoints(array $dataSets): array
	{
		// Printer::p($series, "SERIES in endpoints()"); die();

		$xm = $dataSets[0]->xBounds()['min'];
		$xM = $dataSets[0]->xBounds()['max'];

		$ymins = [];
		$ymaxs = [];

		foreach ($dataSets as $dataSet) {
			$ymins[] = $dataSet->yBounds()['min'];
			$ymaxs[] = $dataSet->yBounds()['max'];
		}

		$ym = min($ymins);
		$yM = max($ymaxs);

		return [(float)$xm, (float)$xM, (float)$ym, (float)$yM];
	}

}