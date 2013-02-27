<?php

namespace SanchoBBDO\Tests\Codes\DumpWriter;

use org\bovigo\vfs\vfsStream;
use SanchoBBDO\Codes\DumpWriter\TextDumpWriter;

class TextDumpWriterTest extends \PHPUnit_Framework_TestCase
{
    protected $root;
    protected $file = 'dump.txt';

    public function setUp()
    {
        $this->root = vfsStream::setup('dump');
        $this->filePath = vfsStream::url("dump/{$this->file}");
        $this->writer = new TextDumpWriter($this->filePath);
    }

    public function tearDown()
    {
        $this->writer->close();
    }

    public function testOpenCreatesFile()
    {
        $this->assertFalse($this->root->hasChild($this->file));
        $this->writer->open();
        $this->assertTrue($this->root->hasChild($this->file));
    }

    public function testWritesToFile()
    {
        $this->writer->open();
        $this->writer->write('Hola');
        $this->writer->write('señor');

        $this->assertEquals("Hola\nseñor\n", file_get_contents($this->filePath));
    }
}
