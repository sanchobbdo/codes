<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCodesCommand extends CodesAwareCommand
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->getCodes() as $code) {
            $output->writeln($code);
        }
    }
}
