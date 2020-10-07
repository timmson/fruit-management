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
     * @param array $order
     * @return array
     */
    public function getAllTasks(array $filter = [], array $order = []): array
    {
        $query = "select * from v_task_all";

        return $this->executeQuery($query, $filter, $order);
    }

    /**
     * @return array
     */
    public function getTasksInProgress(): array
    {
        $query = "select * from v_task_in_progress";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @return array
     */
    function getColumns(): array
    {
        return ["fm_user" => "string"];
    }
}