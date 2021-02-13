<?php


namespace ru\timmson\FruitManagement\util;

use DateTime;
use \PHPUnit\Framework\TestCase;

class CalendarTest extends TestCase
{
    public function testGetTaskEndInTheCurrentDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = Calendar::getTaskEnd($start->getTimestamp(), 1);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-23T10:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheEndIfTheCurrentDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = Calendar::getTaskEnd($start->getTimestamp(), 7);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-23T16:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheNextDay()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = Calendar::getTaskEnd($start->getTimestamp(), 8);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-24T09:00"), $resultInDateTime);
    }

    public function testGetTaskEndInTheNextWeek()
    {
        $start = new DateTime("2020-09-23T09:00");

        $result = Calendar::getTaskEnd($start->getTimestamp(), 24);
        $resultInDateTime = new DateTime("@$result");

        $this->assertEquals(new DateTime("2020-09-28T09:00"), $resultInDateTime);
    }

    public function testGetMonthCalendar() {
        $arrange = new DateTime("2020-09-27T09:00");
        $expected = ['day' => 27, 'isweekend' => true];

        $result = Calendar::getMonthCalendar($arrange->getTimestamp());

        $this->assertEquals($expected, $result[26]);
    }

    public function testIsHolidayIfWorkDayIsGiven() {
        $arrange = new DateTime("2020-09-23T09:00");

        $result = Calendar::isHoliday($arrange->getTimestamp());

        $this->assertFalse($result);
    }

    public function testIsHolidayIfHolidayIsGiven() {
        $arrange = new DateTime("2020-09-26T09:00");

        $result = Calendar::isHoliday($arrange->getTimestamp());

        $this->assertTrue($result);
    }

}