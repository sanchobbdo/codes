<?php

namespace SanchoBBDO\Codes\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use SanchoBBDO\Codes\Codes;

class ValidateCommand extends Command
{
    private $codes;

    public function setCodes(Codes $codes = null)
    {
        $this->codes = $codes;
    }

    public function getCodes()
    {
        return $this->codes;
    }

    protected function configure()
    {
        $this
            ->addArgument(
                'codes',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                'Codes to validate separated by space'
            )
            ->addOption(
                'config',
                'c',
                InputOption::VALUE_REQUIRED,
                'Codes confiuration file path'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputCodes = $input->getArgument('codes');

        try {
            if ($configPath = $input->getOption('config')) {
                $this->loadCodesFromConfig($configPath);
            }

            if (is_null($this->getCodes())) {
                throw new \RuntimeException('A config file must be specified (--config path.yml)');
            }
        } catch (\RuntimeException $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
            return;
        }

        foreach ($inputCodes as $code) {
            if ($this->getCodes()->getCoder()->isValid($code)) {
                $output->writeln("<info>Code {$code} is valid</info>");
            } else {
                $output->writeln("<error>Code {$code} is invalid</error>");
            }
        }
    }

    private function loadCodesFromConfig($path)
    {
        if (!is_file($path)) {
            throw new \RuntimeException("Unable to open file {$path}");
        }

        $config = Yaml::parse($path);
        $this->setCodes(CodesBuilder::buildCodes($config));
    }
}
