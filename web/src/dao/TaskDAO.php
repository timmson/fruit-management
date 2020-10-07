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
    public function getAllTasks()
    {
        return $this->executeQuery("select * from v_task_all");
    }

    /**
     * @return array
     */
    public function getTasksInProgress()
    {
        return $this->executeQuery("select * from v_task_in_progress");
    }
}