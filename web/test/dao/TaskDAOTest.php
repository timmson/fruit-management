<?php

namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/mysqli_wrapper.php");

class TaskDAOTest extends TestCase
{
    /**
     * @var mysqli_wrapper
     */
    private mysqli_wrapper $mysqli;

    /**
     * @var TaskDAO
     */
    private TaskDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new mysqli_wrapper();
        $this->dao = new TaskDAO($this->mysqli);
    }

    public function testGetAllTasks()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all", $arrange);
        $result = $this->dao->getAllTasks();

        $this->assertEquals($arrange, $result);
    }

    public function testGetAllTasksWithFilterAndOrder()
    {
        $arrange = [["name" => "0"]];
        $filter = ["fm_user" => "dummy"];
        $order = ["fm_priority" => "", "id" => ""];

        $this->mysqli->addQueryAndResult("select * from v_task_all where fm_user = 'dummy' order by fm_priority, id", $arrange);
        $result = $this->dao->getAllTasks($filter, $order);

        $this->assertEquals($arrange, $result);
    }

    public function testGetTasksInProgress()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_in_progress", $arrange);
        $result = $this->dao->getTasksInProgress();

        $this->assertEquals($arrange, $result);
    }

}
