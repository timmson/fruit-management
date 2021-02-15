<?php


use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\Core;

class CoreTest extends TestCase
{

    private Core $core;

    protected function setUp(): void
    {
        parent::setUp();
        $this->core = new Core(null);
    }

    public function testInit()
    {
        $this->assertTrue(true);
    }


}
