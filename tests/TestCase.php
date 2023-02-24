<?php

namespace Marzzelo\Tests;

use Marzzelo\Graph\Facades\Graph;
use Marzzelo\Graph\Providers\GraphServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
	// load the package service provider
	protected function getPackageProviders($app): array
	{
		return [GraphServiceProvider::class];
	}

	// load the package aliases
	protected function getPackageAliases($app): array
	{
		return [
			'Graph' => Graph::class,
		];
	}
}