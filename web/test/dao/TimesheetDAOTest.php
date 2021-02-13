<?php


namespace ru\timmson\FruitManagement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/MockConnection.php");

class TimesheetDAOTest extends TestCase
{
    /**
     * @var MockConnection
     */
    private MockConnection $mysqli;

    /**
     * @var TimesheetDAO
     */
    private TimesheetDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new MockConnection();
        $this->dao = new TimesheetDAOImpl($this->mysqli);
    }


    public function testGetCurrentWeekTimesheetTimeSheetByUser()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from fm_timesheet where work_user = 'user' and work_week = week(now()) and work_year = year(now())", $arrange);
        $result = $this->dao->getCurrentWeekTimeSheetByUser("user");

        $this->assertEquals($arrange, $result);
    }

}