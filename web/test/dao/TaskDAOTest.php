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
    public function testFindAll()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all", $arrange);
        $result = $this->dao->findAll();

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testFindById()
    {
        $id = 1;
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all where id = $id", $arrange);
        $result = $this->dao->findById($id);

        $this->assertEquals($arrange[0], $result);
    }

    /**
     * @throws Exception
     */
    public function testFindByName()
    {
        $name = "REL-1";
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_all where fm_name = '$name'", $arrange);
        $result = $this->dao->findByName($name);

        $this->assertEquals($arrange[0], $result);
    }


    /**
     * @throws Exception
     */
    public function testFindAllWithFilterAndOrder()
    {
        $arrange = [["name" => "0"]];
        $filter = ["fm_user" => "dummy"];
        $order = ["fm_priority" => "", "id" => ""];

        $this->mysqli->addQueryAndResult("select * from v_task_all where fm_user = 'dummy' order by fm_priority, id", $arrange);
        $result = $this->dao->findAll($filter, $order);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testFindAllInProgress()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from v_task_in_progress", $arrange);
        $result = $this->dao->findAllInProgress();

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testFindAllInProgressWithFilterAndOrder()
    {
        $arrange = [["name" => "0"]];
        $filter = ["fm_user" => "dummy"];
        $order = ["fm_priority" => "", "id" => ""];

        $this->mysqli->addQueryAndResult("select * from v_task_in_progress where fm_user = 'dummy' order by fm_priority, id", $arrange);
        $result = $this->dao->findAllInProgress($filter, $order);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testFindAllBySubscribedUser()
    {
        $user = "dummy";
        $arrange = [["name" => "0"]];

        $this->mysqli->addQueryAndResult("select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = 'dummy'", $arrange);
        $result = $this->dao->findAllBySubscribedUser($user);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testFindAllByParentId()
    {
        $id = 1;
        $arrange = [["id" => "1"]];

        $this->mysqli->addQueryAndResult("select t.* from fm_relation r, v_task_all t where r.fm_parent = $id and r.fm_child = t.id order by t.fm_priority, t.id", $arrange);
        $result = $this->dao->findAllByParentId($id);

        $this->assertEquals($arrange, $result);
    }

    /**
     * @throws Exception
     */
    public function testChangeParent()
    {
        $arrange = [];

        $this->mysqli->addQueryAndResult("update fm_relation set fm_parent=2 where fm_parent=1 and fm_child=3", $arrange);
        $this->dao->changeParent(3, 1, 2);

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testUpdateStatus()
    {
        $arrange = [];

        $this->mysqli->addQueryAndResult("update fm_task set fm_state = (select id from fm_state where fm_name = 'new') where id = 1", $arrange);
        $this->dao->updateStatus(1, "new");

        $this->assertTrue(true);
    }

    /**
     * @throws Exception
     */
    public function testCreate()
    {
        $arrange = [];
        $task = [
            "fm_name" => "",
            "fm_descr" => "",
            "fm_project" => "",
            "fm_state" => "",
            "fm_priority" => "",
            "fm_plan" => "",
            "fm_user" => ""
        ];

        $this->mysqli->addQueryAndResult("insert into fm_task(id, fm_name, fm_descr, fm_project, fm_state, fm_priority, fm_plan, fm_user) values (null,'','',,,,,'')", $arrange);
        $this->mysqli->setInsertedId(2);
        $result = $this->dao->create($task);

        $task["id"] = 2;

        $this->assertEquals($task, $result);
    }

}
