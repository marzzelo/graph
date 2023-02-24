<?php

namespace Marzzelo\Tests\feature;

use Marzzelo\Tests\TestCase;
use Marzzelo\Graph\Facades\Graph;

class ConfigTest extends TestCase
{

	/** @test */
	public function it_can_load_the_config_file()
	{
		$this->assertEquals('Eureka!', config('graph.test'));
	}

	/** @test
	 * assert that the method help() of the Facade Graph returns a string
	 */
	public function grahp_hello_method_returns_a_string() {
		$this->assertEquals('Hello World!', Graph::hello());
	}

	/** @test
	 * help() returns a string including the parameter
	 */
	public function grahp_hello_method_returns_a_string_with_parameter() {
		$this->assertEquals('Hello parameter!', Graph::hello('parameter'));
	}

	/** @test
	 * can access the route /graph
	 */
	public function can_access_the_route_graph() {
		$response = $this->get('/graph');
		$response->assertStatus(200);
		$response->assertSee('Hello Route!');
	}
}