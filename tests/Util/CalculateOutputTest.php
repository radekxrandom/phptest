<?php

namespace App\Tests\Util;

use App\Util\CalculateOutput;
use PHPUnit\Framework\TestCase;

class CalculateOutputTest extends TestCase
{
    //check if highest value is calculated correctly
    public function testHighestValueInSequence()
    {
        $calculate = new CalculateOutput();
        $result = $calculate->highestValueInSequence(10);

        $this->assertEquals(4, $result);

        //test invalid input

        $result1 = $calculate->highestValueInSequence('test');
        $result2 = $calculate->highestValueInSequence(-10);

        $this->assertEquals("Input not valid.", $result1);
        $this->assertEquals("Input not valid.", $result2);
    }

    //test terminal output
    public function testOutputInputArray()
    {

    //check if output is an array
        $calculate = new CalculateOutput();
        $arr = array(10, 10);
        $result = $calculate -> outputInputArray($arr);

        $this->assertIsArray($result);

        //check invalid input
        $secArr = array(10, 'ff', 2, 'test');

        $result = $calculate->outputInputArray($secArr);
        $shouldEqual = array(4, "Input not valid.", 1, "Input not valid.");

        $this->assertEquals($shouldEqual, $result);
    }
}
