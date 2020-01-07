<?php


namespace Hllizi\PHPMonads;


use PHPUnit\Framework\TestCase;

class MaybeTest extends TestCase
{
    private $nothing;
    private $something;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $this->nothing = new MaybeMonad(null);
        $this->something = new MaybeMonad("Hi");
        parent::__construct($name, $data, $dataName);
    }

    public function testSomethingNothing() {
        $this->assertTrue($this->nothing->isNothing());
        $this->assertTrue($this->something->isSomething());
        $this->assertFalse($this->nothing->isSomething());
        $this->assertFalse($this->something->isNothing());
    }

    public function testGetWithAlternative()
    {
        $this->assertEquals("Test", $this->nothing->getWithAlternative("Test"));
        $this->assertEquals("Test", $this->something->getWithAlternative("Test"));
    }
}