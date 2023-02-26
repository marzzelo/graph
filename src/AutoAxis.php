<?php
declare(strict_types=1);


namespace Marzzelo\Graph;


use Exception;
use InvalidArgumentException;

class AutoAxis extends BasicAxis implements IAxis
{
	/**
	 * AutoAxis constructor.
	 *
	 * @param  array                  $dataSets
	 * @param  \Marzzelo\Graph\Frame  $frame  Frame object
	 * @param  array                  $options
	 * @throws \Exception
	 */
	public function __construct(array $dataSets, Frame $frame, $options = [])
	{
        if (count($dataSets) == 0)
            throw new Exception('No data provided');

        // $data must be an array of IDataSet objects
        if (!($dataSets[0] instanceof IDataSet))
            throw new InvalidArgumentException('Invalid data provided (must be an array of IDataSet objects)');
            

		[$xm, $xM, $ym, $yM] = $this->endpoints($dataSets);
		parent::__construct($xm, $xM, $ym, $yM, $frame, $options);
	}

	/**
	 * Computes the endpoints of the axis
	 *
	 * @param  \Marzzelo\Graph\DataSet[]  $dataSets
	 * @return float[]
	 */
	protected function endpoints(array $dataSets): array
	{
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
