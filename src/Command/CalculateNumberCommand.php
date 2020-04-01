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
        ->addArgument('number', InputArgument::REQUIRED, 'Number n.');
    }


    public function getResults($number)
    {
        function countAn($n)
        {
            //for 0 return 0, for 1 and 2 return 1, afterwards use recursion to
            //"reduce" the number and calculate the result
            if ($n == 0) {
                return 0;
            }

            if ($n == 1 || $n == 2) {
                return 1;
            }

            if ($n % 2 == 0) {
                return countAn($n/2);
            }

            $i = ($n-1)/2;
            return countAn($i) + countAn($i+1);
        }
        function getHighest($a)
        {
            $highest = 0;
            for ($i=0; $i<$a; $i++) {
                $result = countAn($a);

                //swap if current result is higher then the biggest previous number
                if ($result > $highest) {
                    $highest = $result;
                }
                $a--;
            }
            return $highest;
        }
        return getHighest($number);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Description');
        $output->writeln($this->getResults($input->getArgument('number')));

        return 0;
    }
}
