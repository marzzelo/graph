# Marzzelo/Graph

Marzzelo/Graph is a simple Cartesian Graph creation library in PHP.

![Single dataset plot](./screenshot1.png "graph") 

## Installation

Use Composer to install Graph.

```bash
composer require marzzelo/graph
```

## Usage

### CASE 1: Array of data sets in memory

- Define the datasets to plot in the form: `$data = [[x0,y0], [x1,y1], ...]`
```php
$data1 = [[-1500, 1000], [-1000, 800], [-500, 100], [0, -100], [1000, 900], [1500, 1200]];
$data2 = [[-1500, 1200], [-1000, 1000], [-500, 200], [0, 0], [1000, 1100], [1500, 1400]];
...
$dataN = [...];
```
- Create the datasets using the class **DataSet**. 
```php
$dataset1 = new DataSet($data1, 6, '#070');
$dataset2 = new DataSet($data2, 8, '#600');
...
$datasetN = new DataSet($dataN, 8, '#600');
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
        ->addLabels('time[s]', 'current[A], voltage[V]')
// Set grid spacing in physical units (optional)			
        ->setGrid(200, 100);
```

- Define the Graph based on the axis
```php		        
$graph = (new Graph($axis))
         ->addDataSets([
             $dataset1,
             $dataset2,
         ])    
// Get the image to display (render64) or save: $graph->render()->save(Storage::path('images/rectangle.png'))
        ->render64('png');
        
// Or, save the image to a file
$graph->render()->save('graph/testgraph.png');
```

Then, you can use `$img64` content as the `image source` in the `<img />` html tag:
```html
<div class=''>
    <img src="{{$graph}}" alt='' class='mx-auto' />
</div>
```

![from memory array](tests/graph_array.png "graph from memory array")

### CASE 2: Data sets from a CSV file

- From a CSV file (comma separated values) you can create a **CsvFileReader** object. 
  The first line of the file must contain the column names. 
  The following lines must contain the data in the form: `t, I, V` where `t` is the 
  independent variable and `I` and `V` are the dependent variables. 
  The file must be in the same directory as the script or in a subdirectory. 
  The file name must be passed as a parameter to the constructor. 
  The second parameter is the separator character (default is comma).

|   t   |  I   |  V  | 
|:-----:|:----:|:---:|
| -1500 | 1000 | 100 | 
| -1000 | 800  | 80  | 
| -500  | 100  | 10  | 

![from CSV file](tests/graph_csv.png "graph from CSV file")

```php
$csvFile = new CsvFileReader($this->source, ",");
$this->datasets = $csvFile->getDataSets();
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](./LICENSE.md)