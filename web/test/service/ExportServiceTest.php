<?php

namespace ru\timmson\FruitManagement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\dao\Connection;
use ru\timmson\FruitManagement\dao\MockConnection;

require_once(__DIR__ . "/../dao/MockConnection.php");

class ExportServiceTest extends TestCase
{

    private ExportService $service;

    private Connection $connection;

    public function testGetCompletedTasks()
    {
        $expected = ["a1" => "b1"];
        $user = "user";
        $week = 15;

        $this->connection->addResult($expected);
        $result = $this->service->getCompletedTasks($user, $week);

        $this->assertEquals($expected, $result);
    }

    public function testGetPlannedTasks()
    {
        $expected = ["a1" => "b1"];
        $user = "user";

        $this->connection->addQueryAndResult("select * from v_task_in_progress where fm_project <> 'COMMON' and (fm_state_name = 'planned' or fm_state_name = 'in_progress') and fm_user = '$user'", $expected);
        $result = $this->service->getPlannedTasks($user);

        $this->assertEquals($expected, $result);
    }

    public function testGetUncompletedTasks()
    {
        $expected = ["a1" => "b1"];
        $user = "user";
        $week = 15;

        $this->connection->addQueryAndResult("select * from v_task_in_progress where fm_project <> 'COMMON' and fm_state_name = 'in_progress' and id not in (select distinct l.fm_task from  fm_work_log l where week(l.fm_date) = $week) and fm_user = '$user'", $expected);
        $result = $this->service->getUncompletedTasks($user, $week);

        $this->assertEquals($expected, $result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = new MockConnection();
        $this->service = new ExportService($this->connection);
    }

}
