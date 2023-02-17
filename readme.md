# Marzzelo/Graph

Marzzelo/Graph is a simple Cartesian Graph creation library in PHP.

![Single dataset plot](./screenshot1.png "graph") 

## Installation

Use Composer to install Graph.

```bash
composer require marzzelo/graph
```

## Usage

- Define the datasets to plot in the form: `$dataset = [[x0,y0], [x1,y1], ...]`
```php
$dataset1 = [[-1500, 1000], [-1000, 800], [-500, 100], [0, -100], [1000, 900], [1500, 1200]];
$dataset2 = [...];
$datasetN = [...];
```

- Define a _frame_ as a canvas for the the Graph using the class **Frame**. Input the
width, height, background-color and border-color. 
```php
$frame = new Frame(640, 400, '#FFF', '#bbb');
```

 - Define an **Axis** for the Graph (the _AutoAxis_ concrete class is used in this example). 
   You can choose from the following Axis implementations or create your own one: 
   - **AutoAxis** requires all datasets to be passed in order to auto-calculate axis bounds.
   - **BasicAxis** concrete class requires just the upper-left and lower-right points.
```php
$axis = (new AutoAxis([$dataset1, $dataset2,... $datasetN], $frame ))
// Add labels to the Axis (optional)
        ->addLabels('time[s]', 'current[A]', 'OUTPUT CURRENT')
// Set grid spacing in physical units (optional)			
        ->setGrid(500, 100);
```

- Define the Graph based on the axis
```php		        
$graph = (new Graph($axis))
// and add the datasets with their properties (colors, dot sizes, etc)
        ->addDataSets([
            new DataSet($dataset1, 6, '#070'), 
            new DataSet($dataset2, 8, '#600')
        ])
// Get the image to display (render64) or save: $graph->render()->save(Storage::path('images/rectangle.png'))
        ->render64('png');
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

[MIT](./LICENSE.md)
