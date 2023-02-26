<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;
use InvalidArgumentException;

class Graph
{

	private array $options;

	private ?IAxis $axis = null;

	/**
	 * @var \Marzzelo\Graph\IDataSet[]
	 */
	private array $series = [];  // DataSet objects

	private array $labels = [];


	/**
	 * Graph constructor.
	 *
	 * @param  IAxis|null  $axis
	 */
	public function __construct(?IAxis $axis = null)
	{
		$this->options = config('graph.default-options', []);
		if ($axis)
			$this->axis = $axis;
	}

	/**
	 * Returns a canvas with the graph. The graph is drawn using the data from a 2D array.
	 * To save the image to a file, use the save() method of the returned object.
	 * To generate an encoded64 image, use the render64() method of the returned object.
	 *
	 * @param  array  $data     2D array of data in the form [[t, x, y, z], [t, x, y, z], ...]
	 * @param  array  $options  array of options
	 * @return \Marzzelo\Graph\Graph
	 * @throws \Exception
	 */
	public function fromArray(array $data, array $options = []): Graph
	{
		$options = $this->updateOptions($options);

		return $this->makeGraph($options, $data);
	}

	/**
	 * Returns a canvas with the graph. The graph is drawn using the data from a csv file.
	 * To save the image to a file, use the save() method of the returned object.
	 * To generate an encoded64 image, use the render64() method of the returned object.
	 *
	 * @param  string  $csvFile  path to csv file
	 *                           first row must be the headers
	 * @param  array   $options  array of options
	 * @return \Marzzelo\Graph\Graph
	 * @throws \Exception
	 */
	public function fromCsv(string $csvFile, array $options = []): Graph
	{
		$options = $this->updateOptions($options);

		$csvReader = new CsvFileReader($csvFile, $options['csv']['delimiter'], $options['csv']['skip']);

		$this->labels = $csvReader->getHeaders();

		// if set, override the labels from the options array:
		$this->labels[0] = $options['axis']['labels'][0] ?? $this->labels[0];
		$this->labels[1] = $options['axis']['labels'][1] ?? $this->labels[1];

		$data = $csvReader->getRawData();

		return $this->makeGraph($options, $data);
	}


	public function updateOptions(array $options): array
	{
		// update $this->options with new $options:

		$this->options = array_replace_recursive($this->options, $options);
		return $this->options;
	}


	public function addDataSet(IDataSet $dataSet): Graph
	{
		$this->series[] = $dataSet;
		return $this;
	}


	public function addDataSets(array $dataSets): self
	{
		if (!$dataSets[0] instanceof IDataSet)
			throw new InvalidArgumentException('DataSets must be an array of IDataSet objects');
		$this->series = array_merge($this->series, $dataSets);
		return $this;
	}

	public function setDataSets(array $dataSets): self
	{
		if (!$dataSets[0] instanceof IDataSet)
			throw new InvalidArgumentException('DataSets must be an array of IDataSet objects');

		$this->series = $dataSets;
		return $this;
	}

	/**
	 * Draws the graph, incluiding the axis, grid, labels, title, and the data sets.
	 *
	 * @return \Intervention\Image\Image
	 */
	public function render(): Image
	{
		if ($this->labels) {
			$this->axis->setLabels(...$this->labels);
		}

		$canvas = $this->axis->draw();  // ejes, grilla, labels, title

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->axis);    // points, curves
		}

		return $canvas;
	}

	/**
	 * Generates a base64 string with the image data, for use in HTML.
	 *
	 * @param  string  $format
	 * @return string
	 */
	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode((string)$this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}

	/**
	 * Saves the image to a file.
	 *
	 * @param  string  $filename
	 * @param  int     $quality
	 * @return \Intervention\Image\Image
	 */
	public function save(string $filename, int $quality = 90): Image
	{
		return $this->render()->save($filename, $quality);
	}


	/**
	 * This method is used to clamp a value between a minimum and maximum value.
	 * It returns the value if it is between the min and max, or the min or max if it is outside that range.
	 *
	 * @param  float  $x
	 * @param  float  $min
	 * @param  float  $max
	 * @return float $x clamped between $min and $max
	 */
	public static function confineTo(float $x, float $min, float $max): float
	{
		return min(max($min, $x), $max);
	}

	public function hello(string $name = 'World'): string
	{
		return "Hello $name!";
	}

	/**
	 * @param  array  $options
	 * @param  array  $data
	 * @return $this
	 * @throws \Exception
	 */
	public function makeGraph(array $options, array $data): Graph
	{
		$frame = new Frame(
			$options['frame']
		);

		$this->series = [];

		foreach ($data as $i => $data_n) {
			$this->series[] = new DataSet(
				$data_n,
				$options['datasets'][$i] ?? []);
		}

		$this->axis = (new AutoAxis(
			$this->series,
			$frame,
			$options['axis']
		));

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->axis);    // points, curves
		}

		return $this;
	}
}
