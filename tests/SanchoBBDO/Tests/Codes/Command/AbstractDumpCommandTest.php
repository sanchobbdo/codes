<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Tests\Codes\Fixture\DumpCommandFixture;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class AbstractDumpCommandTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $application = new Application();

        $command = new DumpCommandFixture;
        $application->add($command);

        $this->command = $application->find($command->getName());
        $this->definition = $this->command->getDefinition();

        $this->commandTester = new CommandTester($this->command);
    }

    protected function executeCommand($params = array())
    {
        $this->commandTester->execute(array_merge(
            array('command' => $this->command->getName()),
            $params
        ));

        return $this->commandTester->getDisplay();
    }

    public function testSetsDumpAsNameIfActionIsNotDeclared()
    {
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\AbstractDumpCommand');
        $this->assertEquals('dump', $command->getName());
    }

    public function testSetNameAsDumpSemicolonActionIFActionIsDeclared()
    {
        $this->assertEquals('dump:test', $this->command->getName());
    }

    /**
     * @dataProvider actionsProvider
     */
    public function testSetActionSetName($action)
    {
        $this->command->setAction($action);
        $this->assertEquals("dump:{$action}", $this->command->getName());
    }

    public function actionsProvider()
    {
        return array(
            array('foo'),
            array('bar'),
            array('pum'),
            array('pam')
        );
    }

    public function testSecretKeyOption()
    {
        try {
            $option = $this->definition->getOption('secret-key');
            $this->assertEquals('k', $option->getShortcut());
            $this->assertTrue($option->isValueRequired());
        } catch (\InvalidArgumentException $e) {
            $this->fail("Option secret-key is not set");
        }
    }

    public function testLengthOption()
    {
        try {
            $option = $this->definition->getOption('length');
            $this->assertEquals('l', $option->getShortcut());
            $this->assertTrue($option->isValueRequired());
        } catch (\InvalidArgumentException $e) {
            $this->fail("Option length is not set");
        }
    }

    public function testSecretKeyOptionIsRequired()
    {
        $this->assertRegExp('/secret-key/', $this->executeCommand());
    }
}
