<?php

namespace ru\timmson\FruitManagement\dao;

use Exception;
use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/MockConnection.php");

class ProjectDAOTest extends TestCase
{
    private ProjectDAO $projectDAO;

    private Connection $connection;

    protected function setUp():void
    {
        parent::setUp();
        $this->connection = new MockConnection();
        $this->projectDAO = new ProjectDAOImpl($this->connection);
    }

    /**
     * @throws Exception
     */
    public function testGetProjectsWithTaskCountAndSpentHours()
    {
        $arrange = [];

        $this->connection->addQueryAndResult("select p.*, count(c.id) as current_tasks, (select sum(l.fm_spent_hour) from fm_task t, fm_work_log l where t.id = l.fm_task and t.fm_project = p.id ) as fm_spent_hours from fm_project p left join v_task_in_progress c on p.id = c.fm_project_id group by p.id", $arrange);
        $result = $this->projectDAO->getProjectsWithTaskCountAndSpentHours();

        $this->assertEquals($arrange, $result);
    }


}
