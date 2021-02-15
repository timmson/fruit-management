<?php

namespace ru\timmson\FruitManagement\dao;


class ProjectDAOImpl extends AbstractDAO implements ProjectDAO
{

    /**
     * @inheritDoc
     */
    public function getProjectsWithTaskCountAndSpentHours(): array
    {
        $query = "select p.*, count(c.id) as current_tasks, (select sum(l.fm_spent_hour) from fm_task t, fm_work_log l where t.id = l.fm_task and t.fm_project = p.id ) as fm_spent_hours from fm_project p left join v_task_in_progress c on p.id = c.fm_project_id group by p.id";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @inheritDoc
     */
    protected function getColumns(): array
    {
        return [];
    }
}