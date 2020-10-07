<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class TaskDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TaskDAO extends AbstractDAO
{

    /**
     * @return array
     */
    function getColumns(): array
    {
        return ["fm_user" => "string"];
    }

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function getAllTasks(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, $filter, $order);
    }

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function getTasksInProgress(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_in_progress";

        return $this->executeQuery($query, $filter, $order);
    }

    public function getSubscribedTaskByUser(string $user)
    {
        $query = "select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = '$user'";

        return $this->executeQuery($query, [], []);
    }
}