<?php

/**
 * @author  Camilo Aguilar <camiloaguilar@sanchobbdo.com.co>
 * @license MIT http://opensource.org/licenses/MIT
 * @link    https://github.com/sanchobbdo/codes
 */

namespace SanchoBBDO\Codes;

use SanchoBBDO\Codes\Coder\CoderInterface;

class Codes implements \Iterator
{
    private $coder;
    private $offset;
    private $limit;

    protected $position;

    /**
     * @param Coder\CoderInterface
     * @param int
     * @param int
     */
    public function __construct(CoderInterface $coder, $offset = 0, $limit = null)
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

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getLastKey()
    {
        return $this->getOffset() + $this->getLimit() - 1;
    }

    protected function setCoder(CoderInterface $coder)
    {
        $this->coder = $coder;
    }

    /**
     * @param int
     */
    protected function setOffset($offset)
    {
        $this->offset = $offset;
    }

    /**
     * @param int
     * @throws Exception/OffBoundaryException
     */
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
