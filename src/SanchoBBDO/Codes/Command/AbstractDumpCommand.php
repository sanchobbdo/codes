<?php

namespace SanchoBBDO\Codes\Command;

use Jasny\Config;
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
        $this->init();

        $this
            ->addArgument(
                'config',
                InputArgument::OPTIONAL,
                'Config file path'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        try {
            $configFile = $input->getArgument('config');

            if ($configFile) {
                $config = (array) Config::i()->load($input->getArgument('config'));
                $this->setCodes(Codes::from($config));
            }

            $codes = $this->getCodes();

            if (!$codes) {
                throw new \Exception("Not enough arguments.");
            }

            $dumper = new CodesDumper(
                $this->getCodes(),
                $this->getDumpWriter($input, $output)
            );

            $dumper->dump();
        } catch (\Exception $e) {
            $this->getOutput()->writeln('<error>'.$e->getMessage().'</error>');
            return 1;
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

    abstract protected function init();

    abstract public function getDumpWriter(InputInterface $input, OutputInterface $output);
}
