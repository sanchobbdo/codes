<?php

namespace SanchoBBDO\Codes\DumpWriter;

class TextDumpWriter implements DumpWriterInterface
{
    protected $file;
    protected $handle;

    public function __construct($file) {
        $this->file = $file;
    }

    public function open()
    {
        $this->handle = fopen($this->file, 'w');
    }

    public function write($code)
    {

    }

    public function close() {
        fclose($this->handle);
    }
}
