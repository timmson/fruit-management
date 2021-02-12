<?php


namespace ru\timmson\FruitMamangement\dao;

use Exception;

/**
 * Class TaskDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TaskDAOImpl extends AbstractDAO implements TaskDAO
{

    /**
     * @return array
     */
    function getColumns(): array
    {
        return ["fm_user" => "string", "fm_name" => "string", "fm_project" => "string"];
    }

    /**
     * @param int $id
     * @return mixed
     * @throws Exception
     */
    public function getTaskById(int $id)
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, ["id" => $id], [])[0];
    }

    /**
     * @param string $name
     * @return mixed
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
     */
    public function getTasksInProgress(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_in_progress";

        return $this->executeQuery($query, $filter, $order);
    }

    /**
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function getSubscribedTaskByUser(string $user): array
    {
        $query = "select t.* from v_task_all t, fm_subscribe s where s.fm_task = t.id and s.fm_user = '$user'";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function geAllTasksByParentId(int $id): array
    {
        $query = "select t.* from fm_relation r, v_task_all t where r.fm_parent = $id and r.fm_child = t.id order by t.fm_priority, t.id";

        return $this->executeQuery($query, [], []);
    }
}