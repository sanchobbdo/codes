<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes\Command;

use Exporter\Handler;
use SanchoBBDO\Codes\Codes;
use SanchoBBDO\Codes\CodesBuilder;
use SanchoBBDO\Codes\CodesSource;
use SanchoBBDO\Codes\Utils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;

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
            if ($configPath = $input->getArgument('config')) {
                $this->loadFromConfig($configPath);
            }

            if (!$codes = $this->getCodes()) {
                throw new \Exception("Not enough arguments.");
            }

            Handler::create(
                new CodesSource($codes),
                $this->getWriter($input, $output)
            )->export();
        } catch (\Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
            return 1;
        }
    }

    /**
     * Load configuration from yaml file.
     *
     * @param string
     * @return array
     */
    private function loadFromConfig($path)
    {
        if (!is_file($path)) {
            throw new \Exception("Unable to open file {$path}");
        }

        $config = Yaml::parse($path);
        $this->setCodes(CodesBuilder::buildCodes($config));
    }

    public function setCodes(Codes $codes)
    {
        $this->codes = $codes;
    }

    /**
     * @return Codes
     */
    public function getCodes()
    {
        return $this->codes;
    }

    abstract protected function init();

    /**
     * @return \Exporter\Writer\WriterInterface
     */
    abstract protected function getWriter(InputInterface $input, OutputInterface $output);
}
