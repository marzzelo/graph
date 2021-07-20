<?php

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class Graph
{
	private IAxis $axis;

	/**
	 * @var \Marzzelo\Graph\IDataSet[]
	 */
	private array $series;

	private Image $canvas;

	private IFrame $frame;


	public function __construct(IFrame $frame, IAxis $axis)
	{
		$this->frame = $frame;
		$this->axis = $axis;
		$this->canvas = $frame->getCanvas();
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
		$this->series = $dataSets;
	}

	public function render(): Image
	{
		$this->axis->draw($this->canvas, $this->frame->getWidth(), $this->frame->getHeight());

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->canvas, $this->axis, $this->frame->getWidth(), $this->frame->getHeight());
		}

		return $this->canvas;
	}

	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode($this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}
}
