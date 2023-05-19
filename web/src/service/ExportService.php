<?php

namespace ru\timmson\FruitManagement\service;

use Exception;
use ru\timmson\FruitManagement\dao\Connection;

/**
 *
 */
class ExportService implements Service
{

    private Connection $connection;

    public function __construct(Connection $connection)
    {

        $this->connection = $connection;
    }

    public function async(array $request, string $user): array
    {
        return $this->sync($request, $user);
    }

    public function sync(array $request, string $user): array
    {
        $week = $request["week"] ?? date("W");

        return [
            "data" => $this->getCompletedTasks($user, $week),
            "plandata" => $this->getPlannedTasks($user),
            "undata" => $this->getUncompletedTasks($user, $week)
        ];
    }

    /**
     * @throws Exception
     */
    function getCompletedTasks(string $user, int $week): array
    {
        $query = "select t.*, (select group_concat(distinct fm_comment separator '<br/>') from fm_work_log where fm_task = t.id and fm_user='$user' and week(fm_date) = $week and fm_spent_hour > 0) as fm_last_comment from v_task_all t where t.fm_project_id <> 4 and t.id in (select distinct l.fm_task from fm_work_log l where fm_user='$user' and week(l.fm_date) = $week and fm_spent_hour > 0) order by fm_project_id";

        return $this->connection->query($query);
    }

    /**
     * @throws Exception
     */
    function getPlannedTasks(string $user): array
    {
        $query = "select * from v_task_in_progress where fm_project <> 'COMMON' and (fm_state_name = 'planned' or fm_state_name = 'in_progress') and fm_user = '$user'";

        return $this->connection->query($query);
    }

    /**
     * @throws Exception
     */
    function getUncompletedTasks(string $user, mixed $week): array
    {
        $query = "select * from v_task_in_progress where fm_project <> 'COMMON' and fm_state_name = 'in_progress' and id not in (select distinct l.fm_task from  fm_work_log l where week(l.fm_date) = $week) and fm_user = '$user'";

        return $this->connection->query($query);
    }
}
