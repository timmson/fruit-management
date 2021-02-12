<?php

namespace ru\timmson\FruitMamangement\dao;

use Exception;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/MockConnection.php");

class TaskDAOTest extends TestCase
{
    /**
     * @var MockConnection
     */
    private MockConnection $mysqli;

    /**
     * @var TaskDAO
     */
    private TaskDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new MockConnection();
        $this->dao = new TaskDAOImpl($this->mysqli);
    }

    /**
     * @throws Exception
     */
    public function testGetAllTasks()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all", $arrange);
        $result = $this->dao->getAllTasks();

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetTaskById()
    {
        $id = 1;
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all where id = $id", $arrange);
        $result = $this->dao->getTaskById($id);

        $this->assertEquals($arrange[0], $result);
    }

    /**
     * @throws Exception
     */
    public function testGetTaskByName()
    {
        $name = "REL-1";
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all where fm_name = '$name'", $arrange);
        $result = $this->dao->getTaskByName($name);

        $this->assertEquals($arrange[0], $result);
    }


    /**
     * @throws Exception
     */
    public function testGetAllTasksWithFilterAndOrder()
    {
        $arrange = [["name" => "0"]];
        $filter = ["fm_user" => "dummy"];
        $order = ["fm_priority" => "", "id" => ""];

        $this->mysqli->addQueryAndResult("select * from v_task_all where fm_user = 'dummy' order by fm_priority, id", $arrange);
        $result = $this->dao->getAllTasks($filter, $order);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetTasksInProgress()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_in_progress", $arrange);
        $result = $this->dao->getTasksInProgress();

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetInProgressWithFilterAndOrder()
    {
        $arrange = [["name" => "0"]];
        $filter = ["fm_user" => "dummy"];
        $order = ["fm_priority" => "", "id" => ""];

        $this->mysqli->addQueryAndResult("select * from v_task_in_progress where fm_user = 'dummy' order by fm_priority, id", $arrange);
        $result = $this->dao->getTasksInProgress($filter, $order);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testGetSubscribedTaskByUser()
    {
        $user = "dummy";
        $arrange = [["name" => "0"]];

        $this->mysqli->addQueryAndResult("select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = 'dummy'", $arrange);
        $result = $this->dao->getSubscribedTaskByUser($user);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testGeAllTasksByParentId()
    {
        $id = 1;
        $arrange = [["id" => "1"]];

        $this->mysqli->addQueryAndResult("select t.* from fm_relation r, v_task_all t where r.fm_parent = $id and r.fm_child = t.id order by t.fm_priority, t.id", $arrange);
        $result = $this->dao->geAllTasksByParentId($id);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testChangeParent()
    {
        $arrange = [];

        $this->mysqli->addQueryAndResult("update fm_relation set fm_parent=2 where fm_parent=1 and fm_child=3", $arrange);
        $result = $this->dao->changeParent(3, 1, 2);

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testUpdateStatus()
    {
        $arrange = [];

        $this->mysqli->addQueryAndResult("update fm_task set fm_state = (select id from fm_state where fm_name = 'new') where id = 1", $arrange);
        $result = $this->dao->updateStatus(1, "new");

        $this->assertTrue(true);
    }

}
