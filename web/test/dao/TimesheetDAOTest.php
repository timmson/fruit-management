<?php


namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/mysqli_wrapper.php");

class TimesheetDAOTest extends TestCase
{
    /**
     * @var mysqli_wrapper
     */
    private mysqli_wrapper $mysqli;

    /**
     * @var TimesheetDAO
     */
    private TimesheetDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new mysqli_wrapper();
        $this->dao = new TimesheetDAO($this->mysqli);
    }


    public function testGetCurrentWeekTimesheetTimeSheetByUser()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from fm_timesheet where work_user = 'user' and work_week = week(now()) and work_year = year(now())", $arrange);
        $result = $this->dao->getCurrentWeekTimesheetTimeSheetByUser("user");

        $this->assertEquals($arrange, $result);
    }

}