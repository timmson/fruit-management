<?php

namespace ru\timmson\FruitManagement\dao;

require_once(__DIR__ . "/MockConnection.php");

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class GenericDAOTest
 * @package ru\timmson\FruitManagement\dao
 */
class WorkLogDAOTest extends TestCase
{

    /**
     * @var MockConnection
     */
    private MockConnection $connection;

    /**
     * @var WorkLogDAO
     */
    private WorkLogDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connection = new MockConnection();
        $this->dao = new WorkLogDAOImpl($this->connection);
    }

    /**
     * @throws Exception
     */
    public function testGetActivity()
    {
        $user = "user";
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->connection->addQueryAndResult("select * from (select l.*, datediff(curdate(), fm_date) as fm_days_ago, t.fm_name, t.fm_descr from fm_work_log l, v_task_all t where t.id = l.fm_task and l.fm_user <> 'user' order by l.fm_date desc, l.id desc)   a where a.fm_days_ago > -1 and a.fm_days_ago < 5 limit 15", $arrange);
        $result = $this->dao->getActivity($user);

        $this->assertEquals($arrange, $result);

    }

    /**
     * @throws Exception
     */
    public function testGetWorkedLogByWeeks()
    {
        $arrange = [["name" => "0", "work" => "yes"]];
        $project = "project";

        $this->connection->addQueryAndResult("select sum(l.fm_spent_hour) as spent_hours, WEEK(l.fm_date) as week from fm_work_log l, fm_task t where t.id = l.fm_task and t.fm_project = '$project'  and l.fm_spent_hour>0  group by WEEK(l.fm_date)", $arrange);

        $result = $this->dao->getWorkedLog($project);

        $this->assertEquals($arrange, $result);
    }


}
