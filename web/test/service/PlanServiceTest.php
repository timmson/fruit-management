<?php

namespace ru\timmson\FruitManagement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\Core;
use Smarty;

class PlanServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }


    public function testSync()
    {
        $_REQUEST = [
            "release" => 1,
            "plandate" => ""
        ];
        $CORE = $this->createMock(Core::class);
        $VIEW = $this->createMock(Smarty::class);

        $CORE->method("executeQuery")->willReturn([]);
        require_once(__DIR__."/../../include/planeditor.php");

        $this->assertTrue(true);
    }

}
