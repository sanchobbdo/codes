<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Codes;

class CodesIterator implements \Iterator
{
    protected $codes;
    protected $position;

    public function __construct(Codes $codes)
    {
        $this->codes = $codes;
        $this->position = 0;
    }

    public function current()
    {
        return $this->codes->of($this->position);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function next()
    {
        $this->position++;
    }

    public function key()
    {
        return $this->position;
    }

    public function valid()
    {
        return $this->position < $this->codes->length;
    }
}
