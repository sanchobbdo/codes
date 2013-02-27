<?php

namespace SanchoBBDO\Codes;

class CodesDumper
{
    protected $codesIterator;
    protected $writer;

    public function __construct(Codes $codes, DumpWriter\DumpWriterInterface $writer)
    {
        $this->codesIterator = new CodesIterator($codes);
        $this->writer = $writer;
    }

    public function dump()
    {
        $this->writer->open();

        foreach ($this->codesIterator as $code) {
            $this->writer->write($code);
        }

        $this->writer->close();
    }
}
