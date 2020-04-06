<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Util\CalculateOutput;

class CalculateNumberCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:calculate';

    protected function configure()
    {
        $this
        ->addArgument('userInput', InputArgument::IS_ARRAY | InputArgument::REQUIRED, 'Numbers.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Description');
        $calc = new CalculateOutput();
        $output->writeln($calc->outputInputArray($input->getArgument('userInput')));

        return 0;
    }
}
