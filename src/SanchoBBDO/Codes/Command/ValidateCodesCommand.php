<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidateCodesCommand extends CodesAwareCommand
{
    protected function configure()
    {
        $this
            ->addArgument(
                'codes',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Codes to validate separated by space'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputCodes = $input->getArgument('codes');

        foreach ($inputCodes as $code) {
            if ($this->getCodes()->getCoder()->isValid($code)) {
                $output->writeln("<info> Code {$code} is valid </info>");
            } else {
                $output->writeln("<error> Code {$code} is invalid </error>");
            }
        }
    }
}
