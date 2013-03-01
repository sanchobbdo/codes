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
        fwrite($this->handle, "{$code}\n");
    }

    public function close() {
        fclose($this->handle);
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;
    }
}
