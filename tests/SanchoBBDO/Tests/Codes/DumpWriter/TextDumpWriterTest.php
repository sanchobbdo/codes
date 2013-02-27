<?php

namespace SanchoBBDO\Tests\Codes\DumpWriter;

use org\bovigo\vfs\vfsStream;
use SanchoBBDO\Codes\DumpWriter\TextDumpWriter;

class TextDumpWriterTest extends \PHPUnit_Framework_TestCase
{
    protected $root;
    protected $basePath = 'test';
    protected $fileName = 'dump.txt';

    public function setUp()
    {
        $this->root = vfsStream::setup($this->basePath);
        $file = vfsStream::url($this->basePath).'/'.$this->fileName;
        $this->writer = new TextDumpWriter($file);
    }

    public function testOpenCreatesFile()
    {
        $this->assertFalse($this->root->hasChild($this->fileName));
        $this->writer->open();
        $this->assertTrue($this->root->hasChild($this->fileName));
    }
}
