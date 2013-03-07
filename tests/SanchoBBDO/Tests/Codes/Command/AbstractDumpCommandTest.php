<?php

namespace SanchoBBDO\Tests\Codes\Command;

use SanchoBBDO\Codes\Command\AbstractDumpCommand;
use SanchoBBDO\Tests\Codes\Fixture\DumpCommandFixture;

class AbstractDumpCommandTest extends CommandTestCase
{
    protected function createCommand()
    {
        $this->writer = $this->getMock('\\SanchoBBDO\\Codes\\DumpWriter\\DumpWriterInterface');
        $command = $this->getMockForAbstractClass('\\SanchoBBDO\\Codes\\Command\\AbstractDumpCommand', array('dump'));
        $command
            ->expects($this->any())
            ->method('getDumpWriter')
            ->will($this->returnValue($this->writer));

        return $command;
    }

    public function testSecretKeyOption()
    {
        $this->assertInputOption('secret-key', 'k', true, true);
    }

    public function testSecretKeyOptionIsRequired()
    {
        $this->assertRegExp('/secret key/i', $this->executeCommand());
    }

    public function testOffsetOption()
    {
        $this->assertInputOption('offset', 'f', true, true);
    }

    public function testLimitOption()
    {
        $this->assertInputOption('limit', 'l', true, true);
    }

    public function testCallsGetDumpWriterOnExecute()
    {
        $this->command
                ->expects($this->once())
                ->method('getDumpWriter')
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

    public function testGetInputReturnsCommandInput()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf(
            'Symfony\\Component\\Console\\Input\\InputInterface',
            $this->command->getInput()
        );
    }

    public function testGetOutputReturnsCommandOutput()
    {
        $this->executeDefaultCommnad();
        $this->assertInstanceOf(
            'Symfony\\Component\\Console\\Output\\OutputInterface',
            $this->command->getOutput()
        );
    }
}
