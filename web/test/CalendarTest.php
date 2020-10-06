<?php


namespace ru\timmson\FruitMamangement\util;

use DateTime;
use \PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testGetTaskEndInTheCurrentDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = getTaskEnd($start->getTimestamp(), 1);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-23T10:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheEndIfTheCurrentDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = getTaskEnd($start->getTimestamp(), 7);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-23T16:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheNextDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = getTaskEnd($start->getTimestamp(), 8);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-24T09:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheNextWeek()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = getTaskEnd($start->getTimestamp(), 24);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-28T09:00"), $resultInDateTime);
    }

}