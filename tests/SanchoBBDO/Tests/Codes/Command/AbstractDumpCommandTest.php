<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Tests\Codes\Fixture\DumpCommandFixture;
use SanchoBBDO\Tests\Codes\CodesFactory;

class AbstractDumpCommandTest extends CommandTestCase
{
    protected function createCommand()
    {
        $this->writer = $this->getMock('\\Exporter\\Writer\\WriterInterface');
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\\AbstractDumpCommand', array('dump'));
        $command
            ->expects($this->any())
            ->method('getWriter')
            ->will($this->returnValue($this->writer));

        return $command;
    }

    public function testCodesGetterAndSetter()
    {
        $codes = CodesFactory::createCodes();

        $this->command->setCodes($codes);
        $this->assertEquals($codes, $this->command->getCodes());
    }

    public function testDisplayErrorIfNoCodesAreSet()
    {
        $output = $this->executeCommand(array());
        $this->assertContains('enough arguments', $output);
    }

    public function testConfigArgument()
    {
        $this->assertInputArgument('config', false);
    }

    public function testLoadsAndUsesConfigFile()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf('\\SanchoBBDO\\Codes\\Codes', $this->command->getCodes());
    }

    public function testNotifiesIfFileWasNotFound()
    {
        $output = $this->executeCommand(array('config' => 'idontexist.yaml'));
        $this->assertContains('Unable' , $output);
    }

    public function testCallsGetDumpWriterOnExecute()
    {
        $this->command
                ->expects($this->once())
                ->method('getWriter')
                ->will($this->returnValue($this->writer));
        $this->executeDefaultCommnad();
    }

    public function testCalssDumpWriterMethodsOnExecute()
    {
        $this->writer
                ->expects($this->once())
                ->method('open');

        $this->writer
                ->expects($this->exactly(10))
                ->method('write')
                ->with($this->anything());

        $this->writer
                ->expects($this->once())
                ->method('close');

        $this->executeDefaultCommnad();
    }
}
