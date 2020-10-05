<?php
namespace ru\timmson\FruitMamangement\lib;

use \PHPUnit\Framework\TestCase;

class CalendarLibTest extends TestCase
{

    public function testGetTaskEnd()
    {
        $t = new CalendarLib();
        $this->assertEquals(36000, $t->getTaskEnd(60*60*9, 1));
        //$this->assertEquals(57600, $t->getTaskEnd(60*60*9, 7));
        //$this->assertEquals(39600, $t->getTaskEnd(60*60*9, 9));
    }

}