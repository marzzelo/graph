<?php

namespace Marzzelo\Graph\Http\Controllers;

use Marzzelo\Graph\Graph;
use Marzzelo\Graph\CsvFileReader;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;

class GraphController extends Controller
{
	protected array $graph_options = [];

	protected array $datasets = [];

	protected array $data = [];


	/**
	 * @throws \Exception
	 */
	public function index(): Factory|View|Application
	{
		$message = 'Graph Test';

		$data = $this->getTestData();

		$opt = [
			'frame'    => [
				'background-color' => '#CDE',
			],
			'axis'     => [
				'grid-color' => '#FFF',
				'title'      => 'DATA FROM MEMORY ARRAY',
			],
			'datasets' => [
				[
					'line-color' => '#0A0',
					'marker-color' => '#0A0',
					'marker-radius' => 8,
				],
				[
					'line-color' => '#A00',
					'marker-color' => '#A00',
					'marker-radius' => 6,
				],
			],
		];

		$graph1 = (new Graph())->fromArray($data, $opt)->render64();

		$opt = [
			'frame'    => [
				'background-color' => '#FFE1BF',
			],
			'axis' => [
				'title'        => 'DATA FROM CSV FILE',
				'grid-size-xy' => [null, null],
				'labels'       => [null, 'Space, Velocity and Acceleration'],
			],
			'csv'  => [
				'delimiter' => ',',
			],
			'datasets' => [
				[
					'line-color' => '#F00',
					'marker-color' => '#F00',
					'marker-radius' => 6,
				],
				[
					'line-color' => '#0F0',
					'marker-color' => '#0F0',
					'marker-radius' => 6,
				],
				[
					'line-color' => '#00f',
					'marker-color' => '#00f',
					'marker-radius' => 8,
				],
			],
		];

		$graph2 = (new Graph())->fromCsv(public_path('vendor/graph/assets/data.csv'), $opt)->render64();

		return view('graph::graph-test', compact('graph1', 'graph2', 'message'));
	}

	/**
	 * This method returns an array of data to be used in the graph
	 * @return array
	 */
	protected function getTestData(): array
	{
		$data1 = [[-1500, 1000], [-1000, 800], [-500, 100], [0, -100], [1000, 900], [1500, 1200]];
		$data2 = [[-1500, 1200], [-1000, 1000], [-500, 200], [0, 0], [1000, 1100], [1500, 1400]];
		return [$data1, $data2];
	}

	protected function getFileData(): array
	{
		$sep = $this->graph_options['csv']['delimiter'] ?? ',';
		$csvFile = (new CsvFileReader("graph/data2.csv", $sep));

		return $csvFile->getRawData();
	}
}
