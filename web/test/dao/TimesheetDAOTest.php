<?php


namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

class TimesheetDAOTest extends TestCase
{
    public function testGetTimeSheetByWeekAndYear()
    {
        $dao = new TimesheetDAO($connection = null);

        $result = $dao->getTimesheetByWeekAndYear("user", 1,1);

        $this->assertCount(1, $result);

    }

}