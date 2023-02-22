<?php
declare(strict_types=1);


namespace Marzzelo\Graph;


class AutoAxis extends BasicAxis implements IAxis
{
	/**
	 * AutoAxis constructor.
	 *
	 * @param  array                  $data
	 * @param  \Marzzelo\Graph\Frame  $frame   Frame object
	 * @param  int                    $margin  Margin from canvas border to Series curves
	 */
	public function __construct(array $data, Frame &$frame, $options = [])
	{
		[$xm, $xM, $ym, $yM] = $this->endpoints($data);
		parent::__construct($xm, $xM, $ym, $yM, $frame, $options);
	}

	// public function make(float $xm, float $xM, float $ym, float $yM, Frame &$frame, $margin = 20): AutoAxis
	// {
	// 	parent::make($xm, $xM, $ym, $yM, $frame, $margin);
	// 	return $this;
	// }


	/**
	 * @param  \Marzzelo\Graph\DataSet[]  $dataSets
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
