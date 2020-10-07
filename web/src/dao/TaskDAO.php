<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class TaskDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TaskDAO extends AbstractDAO
{

    public function getAllTasks()
    {
        return $this->executeQuery("select * from v_task_all");
    }
}