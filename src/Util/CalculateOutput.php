<?php

namespace App\Util;

class CalculateOutput
{
    private function calcElementValue($index)
    {
        //for 0 return 0, for 1 and 2 return 1, afterwards use recursion to
        //"reduce" the number and calculate the result
        if ($index == 0) {
            return 0;
        }

        if ($index == 1 || $index == 2) {
            return 1;
        }

        if ($index % 2 == 0) {
            return $this->calcElementValue($index/2);
        }

        $index = ($index-1)/2;

        return $this->calcElementValue($index) + $this->calcElementValue($index+1);
    }


    public function highestValueInSequence($n)
    {
        if ($n == 0) {
            return "Input not valid.";
        }

        $highestValue = 0;
        for ($i=0; $i<$n; $i++, $n--) {
            $currentElementValue = $this -> calcElementValue($n);
            if ($currentElementValue > $highestValue) {
                $highestValue = $currentElementValue;
            }
        }

        return $highestValue;
    }
    public function outputInputArray($arr)
    {
        $outputArray = array();
        foreach ($arr as $n) {
            array_push($outputArray, $this->highestValueInSequence($n));
        }

        return $outputArray;
    }
}
