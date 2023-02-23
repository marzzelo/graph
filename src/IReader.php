<?php


namespace Marzzelo\Graph;


interface IReader
{
	public function getDataSets(): array;

	public function getHeaders(): array;

    public function getRawData(): array;
}
