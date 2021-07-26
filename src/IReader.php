<?php


namespace Marzzelo\Graph;


interface IReader
{
	public function getSeries(): array;

	public function getHeaders(): array;
}