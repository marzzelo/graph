<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class Graph
{
	private ?IAxis $axis = null;

	/**
	 * @var \Marzzelo\Graph\IDataSet[]
	 */
	private array $series = [];

	private array $headers = [];


	public function __construct(IAxis $axis)
	{
		$this->axis = $axis;
	}

	public function addDataSet(IDataSet $dataSet): Graph
	{
		$this->series[] = $dataSet;
		return $this;
	}

	/**
	 * @param  \Marzzelo\Graph\IDataSet[]  $dataSets
	 */
	public function addDataSets(array $dataSets): self
	{
		$this->series = array_merge($this->series, $dataSets);
		return $this;
	}

	public function setDataSets(array $dataSets): self
	{
		$this->series = $dataSets;
		return $this;
	}

	public function render(): Image
	{
		if ($this->headers) {
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
		$img64 = base64_encode((string)$this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}

	// Factory a Frame object
	public static function getFrame(int $width_px = 800, int $height_px = 600, string $background_color = '#FFD',
		string $frame_color = '#BBB'): Frame
	{
		return new Frame($width_px, $height_px, $background_color, $frame_color);
	}

	public static function getDataSet(array $data, int $radius = 0, string $color = '#0AA'): DataSet
	{
		return new DataSet($data, $radius, $color);
	}

	public static function getBasicAxis(float $xm, float $xM, float $ym, float $yM, Frame &$frame, $margin = 20):
	BasicAxis
	{
		return new BasicAxis($xm, $xM, $ym, $yM, $frame, $margin);
	}

	public static function getAutoAxis(array $dataSets, Frame &$frame, $margin = 20): AutoAxis
	{
		return new AutoAxis($dataSets, $frame, $margin);
	}

	public static function getCsvFileReader(string $csvFile, string $delimiter = "\t", bool $hasHeaders = true):
	CsvFileReader
	{
		return new CsvFileReader($csvFile, $delimiter, $hasHeaders);
	}

	public static function confineTo(float $x, float $min, float $max): float
	{
		return min(max($min, $x), $max);
	}
}
