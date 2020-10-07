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
        return ["fm_user" => "string", "fm_name" => "string"];
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getTaskById(int $id)
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, ["id" => $id], [])[0];
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function getTaskByName(string $name)
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, ["fm_name" => $name], [])[0];
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

    /**
     * @param string $user
     * @return array
     */
    public function getSubscribedTaskByUser(string $user): array
    {
        $query = "select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = '$user'";

        return $this->executeQuery($query, [], []);
    }
}