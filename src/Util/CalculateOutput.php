<?php

namespace App\Util;

class CalculateOutput
{
    public function calcHighestValue($n)
    {
        if ($n == 0 || $n < 0) {
            return "Input not valid.";
        }

        $highest = 0;
        $sequence = array(1, 1);

        for ($i = 1;  count($sequence)<$n; $i++) {
            $element = $sequence[$i];
            $precedent = $sequence[$i-1];
            array_push($sequence, $element+$precedent);
            array_push($sequence, $element);
        }

        //seemed cleaner to create separate loop than have multiple ifs
        foreach ($sequence as $val) {
            if ($val > $highest) {
                $highest = $val;
            }
        }

        return $highest;
    }

    public function outputInputArray($arr)
    {
        $outputArray = array();
        foreach ($arr as $n) {
            array_push($outputArray, $this->calcHighestValue($n));
        }

        return $outputArray;
    }
}
