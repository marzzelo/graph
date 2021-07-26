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

	private array $headers = [];


	public function __construct(IAxis $axis)
	{
		$this->axis = $axis;
	}

	public function addDataSet(IDataSet $dataSet)
	{
		$this->series[] = $dataSet;
	}

	/**
	 * @param \Marzzelo\Graph\IDataSet[] $dataSets
	 */
	public function addDataSets(array $dataSets): self
	{
		$this->series = array_merge($this->series, $dataSets);
		return $this;
	}

	public function render(): Image
	{
		if($this->headers) {
			$this->axis->addLabels($this->headers);
		}
		$canvas = $this->axis->draw();  // ejes, grilla, labels, title

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->axis);    // points, curves
		}

		return $canvas;
	}

	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode((string) $this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}
}
