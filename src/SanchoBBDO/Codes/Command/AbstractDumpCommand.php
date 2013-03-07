<?php

namespace SanchoBBDO\Codes\Command;

use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesDumper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDumpCommand extends Command
{
    private $input;
    private $output;
    private $codes;

    public function configure()
    {

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $codes = $this->getCodes();

        if (!$codes) {
            $output->writeln('<error>Error!</error>');
            return 1;
        }

        try {
            $dumper = new CodesDumper($this->getCodes(), $this->getDumpWriter());
            $dumper->dump();
        } catch (\Exception $e) {
            $this->getOutput()->writeln('<error>'.$e->getMessage().'</error>');
        }
    }

    public function setCodes(Codes $codes)
    {
        $this->codes = $codes;
    }

    public function getCodes()
    {
        return $this->codes;
    }

    public function getInput()
    {
        return $this->input;
    }

    public function getOutput()
    {
        return $this->output;
    }

    abstract public function getDumpWriter();
}
