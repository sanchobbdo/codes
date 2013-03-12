<?php

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Coder\CoderInterface;

class Codes implements \Iterator
{
    private $coder;
    private $offset;
    private $limit;

    protected $position;

    public function __construct($coder, $offset = 0, $limit = null)
    {
        $this->setCoder($coder);
        $this->setOffset($offset);
        $this->setLimit($limit);
        $this->rewind();
    }

    public function current()
    {
        return $this->getCoder()->encode($this->position);
    }

    public function rewind()
    {
        $this->position = $this->getOffset();
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
        return $this->position <= $this->getLastKey();
    }

    public function getCoder()
    {
        return $this->coder;
    }

    public function getOffset()
    {
        return $this->offset;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getLastKey()
    {
        return $this->getOffset() + $this->getLimit() - 1;
    }

    protected function setCoder(CoderInterface $coder)
    {
        $this->coder = $coder;
    }

    protected function setOffset($offset)
    {
        $this->offset = $offset;
    }

    protected function setLimit($limit = null)
    {
        $boundary = $this->getCoder()->getBoundary();
        $offset   = $this->getOffset();
        $limit    = $limit ?: $boundary - $offset;

        if ($limit + $offset > $boundary) {
            throw new Exception\OffBoundaryException("Passed limit {$limit} exceeds permited boundary {$boundary}");
        }

        $this->limit = $limit;
    }
}
