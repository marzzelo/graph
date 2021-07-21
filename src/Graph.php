<?php declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class Graph
{
	private IAxis $axis;

	/**
	 * @var \Marzzelo\Graph\IDataSet[]
	 */
	private array $series = [];

	private IFrame $frame;


	public function __construct(IFrame $frame, IAxis $axis)
	{
		$this->frame = $frame;
		$this->axis = $axis;
	}

	public function addDataSet(IDataSet $dataSet)
	{
		$this->series[] = $dataSet;
	}

	/**
	 * @param \Marzzelo\Graph\IDataSet[] $dataSets
	 */
	public function addDataSets(array $dataSets)
	{
		$this->series = array_merge($this->series, $dataSets);
	}

	public function render(): Image
	{
		$canvas = $this->frame->getCanvas();
		$this->axis->draw($canvas);

		foreach ($this->series as $dataSet) {
			$dataSet->draw($canvas, $this->axis);
		}

		return $canvas;
	}

	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode((string) $this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}
}
