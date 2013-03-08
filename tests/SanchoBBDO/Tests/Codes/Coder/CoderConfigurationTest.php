<?php

namespace SanchoBBDO\Tests\Codes\Coder;

use SanchoBBDO\Codes\Coder\CoderConfiguration;
use Symfony\Component\Config\Definition\Processor;

class CoderConfigurationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->configuration = new CoderConfiguration();
        $this->processor = new Processor();
    }

    private function processConfiguration($config)
    {
        return $this->processor->processConfiguration($this->configuration, array($config));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testSecretKeyIsRequired()
    {
        $this->processConfiguration(array());
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testSecretKeyCannotBeEmpty()
    {
        $this->processConfiguration(array('sercert_key' => ''));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testMacLengthMustBeInt()
    {
        $this->processConfiguration(array(
            'secret_key' => 'adasda',
            'mac_length' => 'dsadas'
        ));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testMacLengthMustBeGreaterThan1()
    {
        $this->processConfiguration(array(
            'secret_key' => 'adasda',
            'mac_length' => 0
        ));
    }

    public function testMacLengthDefaultIs6()
    {
        $config = $this->processConfiguration(array('secret_key' => 'adasda'));
        $this->assertEquals(6, $config['mac_length']);
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testKeyLengthMustBeInt()
    {
        $this->processConfiguration(array(
            'secret_key' => 'adasda',
            'key_length' => 'dsadas'
        ));
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testKeyLengthMustBeGreaterThan1()
    {
        $this->processConfiguration(array(
            'secret_key' => 'adasda',
            'key_length' => 0
        ));
    }

    public function testKeyLengthDefaultIs4()
    {
        $config = $this->processConfiguration(array('secret_key' => 'adasda'));
        $this->assertEquals(4, $config['key_length']);
    }

    public function testAlgoAcceptsValuesInHashAlgos()
    {
        try {
            foreach (hash_algos() as $algo)
            {
                $config = $this->processConfiguration(array('secret_key' => 'sdfsadf', 'algo' => $algo));
            }
        } catch(\Exception $e) {
            $this->fail("{$algo} was rejected");
        }
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testAlgoRejectsValuesNotInHashAlgo()
    {
        $this->processConfiguration(array('secret_key' => 'asdsadas', 'algo' => 'notvalied'));
    }

    public function testAlgoDefaultValueIsSha1()
    {
        $config = $this->processConfiguration(array('secret_key' => 'dsadas'));
        $this->assertEquals('sha1', $config['algo']);
    }
}
