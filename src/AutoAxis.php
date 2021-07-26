<?php
declare(strict_types=1);


namespace Marzzelo\Graph;


use Intervention\Image\Image;

class AutoAxis extends BasicAxis implements IAxis
{
	/**
	 * AutoAxis constructor.
	 * @param array                     $series Array of arrays of [x, y]:  [ $dataset1,  [[0,3],[1,4],[2,7]], ..., $dataset_n ].
	 * @param float|int                 $margin Margin from canvas border to Series curves
	 */
	public function __construct(array $series, Frame &$frame, float $margin = 20)
	{
		[$xm, $xM, $ym, $yM] = $this->endpoints($series);

		// Printer::p($xm, "xm");
		// Printer::p($xM, "xM");
		// Printer::p($ym, "ym");
		// Printer::p($yM, "yM");

		parent::__construct($xm, $xM, $ym, $yM, $frame, $margin);
	}


	/**
	 * @param \Marzzelo\Graph\DataSet[] $series
	 * @return float[]
	 */
	protected function endpoints(array $series): array
	{
		// Printer::p($series, "SERIES in endpoints()"); die();

		// TODO: Usar métodos xBounds e yBounds de DataSet
		$xm = $series[0]->xBounds()['min'];
		$xM = $series[0]->xBounds()['max'];

		$ymins = [];
		$ymaxs = [];

		foreach ($series as $dataSet) {
			$ymins[] = $dataSet->yBounds()['min'];
			$ymaxs[] = $dataSet->yBounds()['max'];
		}

		$ym = min($ymins);
		$yM = max($ymaxs);

		// array_walk($datax, function(&$item) {
		// 	$item = (float)$item;
		// });
		// array_walk($datay, function(&$item) {
		// 	$item = (float)$item;
		// });

		// Printer::p($xmin, 'xmin');
		// Printer::p($xmax, 'xmax');
		// Printer::p($ymin, 'ymin');
		// Printer::p($ymax, 'ymax');

		// $xm = (float)min($datax);
		// $xM = (float)max($datax);
		// $ym = (float)min($datay);
		// $yM = (float)max($datay);

		// dd([$xm, $xM, $ym, $yM]);
		return [(float)$xm, (float)$xM, (float)$ym, (float)$yM];
	}

}