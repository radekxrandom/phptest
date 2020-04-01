<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class CalculateNumberCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:calculate';

    protected function configure()
    {
        $this
        ->addArgument('userInput', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Numbers.');
    }


    public function calcOutput($userInput)
    {
        function calcElementValue($index)
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
                return calcElementValue($index/2);
            }

            $index = ($index-1)/2;

            return calcElementValue($index) + calcElementValue($index+1);
        }

        function highestValueInSequence($n)
        {
            $highestValue = 0;

            if (!is_numeric($n)) {
                return("Value not a number");
            } elseif ($n == 0) {
                return("0 is not valid as input");
            }

            for ($i=0; $i<$n; $i++, $n--) {
                $currentElementValue = calcElementValue($n);

                //swap if current result is higher then the biggest previous number
                if ($currentElementValue > $highestValue) {
                    $highestValue = $currentElementValue;
                }
            }

            return $highestValue;
        }

        //create and return array with highest values
        $outputArray = array();
        foreach ($userInput as $n) {
            array_push($outputArray, highestValueInSequence($n));
        }

        return $outputArray;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Description');
        $output->writeln($this->calcOutput($input->getArgument('userInput')));

        return 0;
    }
}
