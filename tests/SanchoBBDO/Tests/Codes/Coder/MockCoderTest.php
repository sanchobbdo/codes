<?php

namespace SanchoBBDO\Tests\Codes\Coder;

class MockCoderTest extends CoderImplementationTestCase
{
    public function getCoder()
    {
        return new MockCoder();
    }
}
