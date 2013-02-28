<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesDumper;
use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Codes\DumpWriter\ConsoleDumpWriter;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCommand extends AbstractDumpCommand
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $secretKey = $input->getOption('secret-key');

        if (!$secretKey) {
            $output->writeln('<error>You must specify a --secret-key (-k)</error>');
            return;
        }

        $config['secret_key'] = $secretKey;

        if ($length = $input->getOption('length')) {
            $config['length'] = (int) $length;
        }

        $dumper = new CodesDumper(
            new Codes($config),
            new ConsoleDumpWriter($output)
        );

        $dumper->dump();
    }

    public function getDumpWriter()
    {
        return new ConsoleDumpWriter();
    }
}
