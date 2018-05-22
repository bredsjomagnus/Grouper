<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Src\Dev as Dev;

class DevTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testWeight()
    {
		$dev = new Dev();
		$choiceids = [1,2,3,4,5,6];
		$weightarray = $dev->weightArray($choiceids);
		// print_r($weightarray);
        $this->assertEquals(count($weightarray), count($choiceids));
		$this->assertEquals(100, array_sum($weightarray));
    }

	public function testSwitcharray() {
		$dev = new Dev();
		$weightarray = [30, 5, 20, 10, 10, 25];
		$testarray = [0, 30, 35, 55, 65, 75, 100];
		$switcharray = $dev->switchArray($weightarray);
		// print_r($switcharray);
		$this->assertEquals($testarray, $switcharray);
	}
}
