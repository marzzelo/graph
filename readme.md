# Marzzelo/Graph

Marzzelo/Graph is a simple Cartesian Graph creation library in PHP.

![Single dataset plot](./screenshot1.png "graph") 

## Installation

Use Composer to install Graph.

```bash
composer require marzzelo/graph
```

## Usage

```php
// Define the datasets to plot in the form: $dataset = [[x0,y0], [x1,y1], ...]
$dataset1 = [[-1500, 1000], [-1000, 800], [-500, 100], [0, -100], [1000, 900], [1500, 1200]];
$dataset2 = [...];
$datasetN = [...];

// Define an Axis for the Graph (the AutoAxis type is used in this example)
// The AutoAxis type requires all datasets to be passed to auto calculate mins and maxs coordinates.
// BasicAxis requires just the upper-left and lower-right points.
$axis = new AutoAxis([$dataset1, $dataset2,... $datasetN], $margin, 'My Graph Title');

// Add labels to the Axis (optional)
$axis->addLabels(['time[s]', 'current[A]']);

// Set grid spacing (optional)
$axis->setGrid(10, 50);

// Define the Graph area (canvas) dimensions (mandatory) and colors (optional)
$frame = new Frame(640, 480, '#FFF', '#bbb');

// Define the Graph using a frame and an axis
$graph = new Graph($frame, $axis);

// Add the datasets with their properties (colors, dot sizes, etc)
$graph->addDataSets([
    new DataSet($dataset1, 6, '#070'), 
    new DataSet($dataset2, 8, '#600')
]);

// Get the image to display or save:
$img64 = $graph->render64('png');
```

Then, you can use `$img64` content as the `image source` in the `<img />` html tag:
```html
<div class=''>
    <img src="{{$img64}}" alt='' class='mx-auto' />
</div>
```


## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)