<?php


namespace Marzzelo\Graph;


class AutoAxis extends BasicAxis implements IAxis
{
	public function __construct(array $data, float $margin = 20, string $title = '')
	{
		[$xm, $xM, $ym, $yM] = $this->endpoints($data);

		// $axis = new BasicAxis(new XYPoint($xm, $yM), new XYPoint($xM, $ym), 20, 'ERROR RELATIVO PARA MOD-' . $module->label);

		parent::__construct(new XYPoint($xm, $yM), new XYPoint($xM, $ym), $margin, $title);
	}

	protected function endpoints(array $data): array
	{
		$xm = (float)min(array_column($data, 0));
		$xM = (float)max(array_column($data, 0));
		$ym = (float)min(array_column($data, 1));
		$yM = (float)max(array_column($data, 1));
		return [$xm, $xM, $ym, $yM];
	}
}