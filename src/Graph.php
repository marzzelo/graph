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

	public function render(): Image
	{
		$this->axis->draw($this->canvas, $this->frame->width_px, $this->frame->height_px);

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->canvas, $this->axis, $this->frame->width_px, $this->frame->height_px);
		}

		return $this->canvas;
	}

	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode($this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}
}
