<?php


namespace Marzzelo\Graph;


class AutoAxis extends BasicAxis implements IAxis
{
	/**
	 * AutoAxis constructor.
	 * @param array     $series Array of DataSets:  [ $dataset1,  [[0,3],[1,4],[2,7]], ..., $dataset_n ].
	 * @param float|int $margin Margin from canvas border to Series curves
	 * @param string    $title  Graph main title
	 */
	public function __construct(array $series, float $margin = 20, string $title = '')
	{
		[$xm, $xM, $ym, $yM] = $this->endpoints($series);

		// $axis = new BasicAxis(new XYPoint($xm, $yM), new XYPoint($xM, $ym), 20, 'ERROR RELATIVO PARA MOD-' . $module->label);

		parent::__construct(new XYPoint($xm, $yM), new XYPoint($xM, $ym), $margin, $title);
	}

	protected function endpoints(array $series): array
	{
		$datax = [];
		$datay = [];

		foreach ($series as $dataSet) {
			$datax = array_merge($datax, array_column($dataSet, 0));
			$datay = array_merge($datay, array_column($dataSet, 1));
		}

		$xm = (float)min($datax);
		$xM = (float)max($datax);
		$ym = (float)min($datay);
		$yM = (float)max($datay);

		return [$xm, $xM, $ym, $yM];
	}

}