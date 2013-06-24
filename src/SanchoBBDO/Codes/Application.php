<?php

namespace SanchoBBDO\Codes;

use Symfony\Component\Console\Application as BaseApplication;

use SanchoBBDO\Codes\Command\DumpCodesCommand;
use SanchoBBDO\Codes\Command\ValidateCodesCommand;
use SanchoBBDO\Codes\CodesBuilder;
use SanchoBBDO\Codes\Command\CodesAwareCommand;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

class Application extends BaseApplication
{
    protected function getDefaultCommands()
    {
        $commands = parent::getDefaultCommands();
        $commands[] = new DumpCodesCommand('dump');
        $commands[] = new ValidateCodesCommand('validate');

        return $commands;
    }

    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption(
            '--config',
            '-c',
            InputOption::VALUE_REQUIRED,
            'Codes config file path'
        ));

        return $definition;
    }

    protected function doRunCommand(Command $command, InputInterface $input, OutputInterface $output)
    {
        if ($command instanceof CodesAwareCommand) {
            $path = $input->getParameterOption(array('--config', '-c'));
            if (empty($path)) {
                $output->writeln('<error> A config file must be specified (--config path.yml) </error>');
                return 1;
            }

            if (!is_file($path)) {
                $output->writeln("<error> Unable to open file {$path} </error>");
                return 1;
            }

            $config = Yaml::parse($path);
            $codes = CodesBuilder::buildCodes($config);
            $command->setCodes($codes);
        }

        parent::doRunCommand($command, $input, $output);
    }
}
