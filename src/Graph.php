<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;

class Graph
{
	private array $options = [
		'frame' => [
			'width_px'         => 640,
			'height_px'        => 400,
			'background_color' => '#FFE',
			'frame_color'      => '#bbb',
		],

		'axis' => [
			'grid-size-xy'   => [null, null],
			'labels' => [null, null],
			'margin' => 20,  // can be array [x, y] or int
			'title'  => '',
			'title-color' => '#000',
			'axis-color'  => '#555', // color of axis lines
			'grid-color' => '#ddd',
			'background-color' => '#fff',
			'labels-color' => '#555',
		],

		'dataset' => [
			'line-color' => '#00A',
			'marker-radius' => 0,
			'marker-color'  => '#00A',
		],

		'csv.separator' => ',',
		'csv.skip'      => 0,
	];

	private ?IFrame $frame = null;

	private ?IAxis $axis = null;

	/**
	 * @var \Marzzelo\Graph\IDataSet[]
	 */
	private array $series = [];  // DataSet objects

	private array $headers = [];


	/**
	 * Graph constructor.
	 *
	 * @param  IAxis|null  $axis
	 */
	public function __construct(?IAxis $axis = null)
	{
		if ($axis)
			$this->make($axis);
	}

	public function make(IAxis $axis): Graph
	{
		$this->axis = $axis;
		return $this;
	}

	public function addOptions(array $options): array
	{
		// update $this->options with new $options:
		$this->options = array_merge($this->options, $options);
		return $this->options;
	}

	/**
	 * @param  array  $data     2D array of data in the form [[t, x, y, z], [t, x, y, z], ...]
	 * @param  array  $options  array of options
	 */
	public function fromArray(array $data, array $options = []): Image
	{
		$options = $this->addOptions($options);

		$this->frame = new Frame(
			$options['frame']
		);

		foreach ($data as $data_n) {
			$this->series[] = new DataSet(
				$data_n,
				$options['dataset']);
		}

		$this->axis = (new AutoAxis(
			$this->series,
			$this->frame,
			$options['axis']
		));

		$canvas = $this->axis->draw();  // ejes, grilla, labels, title

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->axis);    // points, curves
		}

		return $canvas;

	}

	public function addDataSet(IDataSet $dataSet): Graph
	{
		$this->series[] = $dataSet;
		return $this;
	}


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
			$this->axis->setLabels($this->headers);
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
	public static function getFrame(array $options): Frame
	{
		return new Frame($options);
	}

	public static function getDataSet(array $data, array $options): DataSet
	{
		return new DataSet($data, $options);
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
