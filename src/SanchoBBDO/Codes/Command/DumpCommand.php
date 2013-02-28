<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('dump')
            ->setDescription('Dumps codes to screen')
            ->addOption(
                'secret-key',
                'k',
                InputOption::VALUE_REQUIRED,
                'Secret key to generate codes'
            )
            ->addOption(
                'length',
                'l',
                InputOption::VALUE_REQUIRED,
                'How many codes to generate'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {

    }
}
