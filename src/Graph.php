<?php
declare(strict_types=1);

namespace Marzzelo\Graph;

use Intervention\Image\Image;
use InvalidArgumentException;

class Graph
{
	
	private array $options;

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
		$this->options = config('graph', 'default-options');
		if ($axis)
			$this->make($axis);
	}

	public function make(IAxis $axis): Graph
	{
		$this->axis = $axis;
		return $this;
	}


	/**
	 * @param  array  $data     2D array of data in the form [[t, x, y, z], [t, x, y, z], ...]
	 * @param  array  $options  array of options
	 * @throws \Exception
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

	/**
	 * Returns a canvas with the graph. The graph is drawn using the data from a csv file.
	 * To save the image to a file, use the save() method of the returned object.
	 * To generate an encoded64 image, use the render64() method of the returned object.
	 *
	 * @param  string  $csvFile  path to csv file
	 *                           first row must be the headers
	 * @param  array  $options   array of options
	 * @return \Intervention\Image\Image
	 * @throws \Exception
	 */
	public function fromCsv(string $csvFile, array $options = []): Image {
        $options = $this->addOptions($options);

        $this->frame = new Frame(
            $options['frame']
        );

        $csvReader = new CsvFileReader($csvFile, $options['csv']['delimiter'], $options['csv']['skip']);

        $this->headers = $csvReader->getHeaders();

        foreach ($csvReader->getRawData() as $data_n) {
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


    public function addOptions(array $options): array
	{
		// update $this->options with new $options:
		$this->options = array_merge($this->options, $options);
		return $this->options;
	}


	public function addDataSet(IDataSet $dataSet): Graph
	{
		$this->series[] = $dataSet;
		return $this;
	}


	public function addDataSets(array $dataSets): self
	{
		if (! $dataSets[0] instanceof IDataSet)
			throw new InvalidArgumentException('DataSets must be an array of IDataSet objects');
		$this->series = array_merge($this->series, $dataSets);
		return $this;
	}

	public function setDataSets(array $dataSets): self
	{
        if (! $dataSets[0] instanceof IDataSet)
            throw new InvalidArgumentException('DataSets must be an array of IDataSet objects');

		$this->series = $dataSets;
		return $this;
	}

	/**
	 * Draws the graph, incluiding the axis, grid, labels, title, and the data sets.
	 * @return \Intervention\Image\Image
	 */
	public function render(): Image
	{
		if ($this->headers) {
			$this->axis->setLabels(...$this->headers);
		}
		$canvas = $this->axis->draw();  // ejes, grilla, labels, title

		foreach ($this->series as $dataSet) {
			$dataSet->draw($this->axis);    // points, curves
		}

		return $canvas;
	}

	/**
	 * Generates a base64 string with the image data, for use in HTML.
	 * @param  string  $format
	 * @return string
	 */
	public function render64(string $format = 'png'): string
	{
		$img64 = base64_encode((string)$this->render()->encode($format));

		return "data:image/$format;base64,$img64";
	}

	// // Factory a Frame object
	// public static function getFrame(array $options): Frame
	// {
	// 	return new Frame($options);
	// }
	//
	// public static function getDataSet(array $data, array $options): DataSet
	// {
	// 	return new DataSet($data, $options);
	// }
	//
	// /**
	//  * @throws \Exception
	//  */
	// public static function getBasicAxis(float $xm, float $xM, float $ym, float $yM, Frame &$frame, $margin = 20):
	// BasicAxis
	// {
	// 	return new BasicAxis($xm, $xM, $ym, $yM, $frame, $margin);
	// }
	//
	// /**
	//  * @throws \Exception
	//  */
	// public static function getAutoAxis(array $dataSets, Frame &$frame, $margin = 20): AutoAxis
	// {
	// 	return new AutoAxis($dataSets, $frame, $margin);
	// }
	//
	// public static function getCsvFileReader(string $csvFile, string $delimiter = "\t", bool $hasHeaders = true):
	// CsvFileReader
	// {
	// 	return new CsvFileReader($csvFile, $delimiter, $hasHeaders);
	// }

	/**
	 * This method is used to clamp a value between a minimum and maximum value.
	 * It returns the value if it is between the min and max, or the min or max if it is outside that range.
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
}
