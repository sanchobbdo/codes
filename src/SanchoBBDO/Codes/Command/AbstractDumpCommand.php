<?php

namespace SanchoBBDO\Codes\Command;

use Jasny\Config;
use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesDumper;
use SanchoBBDO\Codes\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractDumpCommand extends Command
{
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
        try {
            $configFile = $input->getArgument('config');

            if ($configFile) {
                $config = Utils::object2array(Config::i()->load($input->getArgument('config')));
                $this->setCodes(Codes::from($config));
            }

            $codes = $this->getCodes();

            if (!$codes) {
                throw new \Exception("Not enough arguments.");
            }

            $dumper = new CodesDumper(
                $codes,
                $this->getDumpWriter($input, $output)
            );

            $dumper->dump();
        } catch (\Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
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

    abstract protected function init();

    abstract protected function getDumpWriter(InputInterface $input, OutputInterface $output);
}
