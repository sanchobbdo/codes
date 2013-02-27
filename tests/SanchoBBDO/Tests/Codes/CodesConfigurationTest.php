<?php

namespace SanchoBBDO\Tests\Codes;

use SanchoBBDO\Codes\CodesConfiguration;
use Symfony\Component\Config\Definition\Processor;

class CodesConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->config = new CodesConfiguration;
    }

    protected function process($config)
    {
        $processor = new Processor;
        return $processor->processConfiguration($this->config, array($config));
    }

    public function testImplementsConfigurationInterface()
    {
        $this->assertInstanceOf('Symfony\\Component\\Config\\Definition\\ConfigurationInterface', $this->config);
    }

    public function testSecretKey()
    {
        try {
            $this->process(array(
                'secret_key' => 'fdsdfsdafsdfa'
            ));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testSecretKeyIsRequired()
    {
        $this->process(array());
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testSecretKeyCannotEmpty()
    {
        $this->process(array(
            'secret_key' => ''
        ));
    }

    public function testLength()
    {
        try {
            $this->process(array(
                'secret_key' => 'fdsdfsdafsdfa',
                'length' => 12345
            ));
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLengthIsInteger()
    {
        $this->process(array(
            'secret_key' => 'adsadas',
            'length' => 'asfdsfsd'
        ));
    }


    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testLengthmustBePositive()
    {
        $this->process(array(
            'secret_key' => 'adsadas',
            'length' => -1
        ));
    }
}
