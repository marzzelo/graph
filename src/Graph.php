<?php

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class Graph
{
	private IAxis $axis;

	private IDataSet $dataSet;

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
		$this->dataSet = $dataSet;
	}

	public function render(): Image
	{
		$this->axis->draw($this->canvas, $this->frame->width_px, $this->frame->height_px);

		$this->dataSet->draw($this->canvas, $this->axis, $this->frame->width_px, $this->frame->height_px);

		return $this->canvas;
	}

	public function render64(): string
	{
		$img64 = base64_encode($this->render()->encode('png'));

		return "data:image/jpeg;base64,$img64";
	}
}
