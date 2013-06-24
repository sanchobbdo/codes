<?php

namespace SanchoBBDO\Tests\Codes;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Console\Tester\ApplicationTester;

use SanchoBBDO\Codes\Application;
use SanchoBBDO\Codes\CodesBuilder;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    private $application;
    private $configPath;

    public function setUp()
    {
        $this->configPath = dirname(__DIR__).'/Codes/Fixture/config.yaml';
        $this->application = new Application();
        $this->application->setAutoExit(false);
    }

    private function execute($command, $params = array(), $useConfig = true)
    {
        $tester = new ApplicationTester($this->application);

        // Command must be the first key
        $params = array_merge(array('command' => $command), $params);

        if ($useConfig) {
            $params['--config'] = $this->configPath;
        }

        $tester->run($params);

        return $tester;
    }

    private function getCodes()
    {
        $config = Yaml::parse($this->configPath);
        $codes = CodesBuilder::buildCodes($config);

        return $codes;
    }

    public function testConfigInInputDefinition()
    {
        $tester = $this->execute('help', array(), false);
        $this->assertContains('--config', $tester->getDisplay());
    }

    public function testDumpCodes()
    {
        $tester = $this->execute('dump');

        foreach ($this->getCodes() as $code) {
            $this->assertContains($code, $tester->getDisplay());
        }
    }

    public function testValidateCodes()
    {
        $codes = array();
        foreach ($this->getCodes() as $code) {
            $codes[$code] = 'valid';
            $codes[substr($code, 0, -1).'x'] = 'invalid';
        }

        $tester = $this->execute('validate', array('codes' => array_keys($codes)));

        $output = $tester->getDisplay();
        foreach ($codes as $code => $validity) {
            $this->assertRegExp("/{$code}.*?\s{$validity}/", $output, "Code {$code} is not {$validity}");
        }
    }

    public function testOnNoConfig()
    {
        $tester = $this->execute('dump', array(), false);

        foreach ($this->getCodes() as $code) {
            $this->assertContains('--config', $tester->getDisplay());
        }
    }

    public function testOnInvalidconfig()
    {
        $tester = $this->execute('dump', array('--config' => 'ab'), false);

        foreach ($this->getCodes() as $code) {
            $this->assertContains('open', $tester->getDisplay());
        }
    }
}
