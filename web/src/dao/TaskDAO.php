<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class TaskDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TaskDAO extends AbstractDAO
{

    /**
     * @param array $filter
     * @return array
     */
    public function getAllTasks($filter = []): array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, $filter);
    }

    /**
     * @return array
     */
    public function getTasksInProgress(): array
    {
        return $this->executeQuery("select * from v_task_in_progress");
    }

    /**
     * @return array
     */
    function getColumns(): array
    {
        return ["fm_user" => "string"];
    }
}