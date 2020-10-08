<?php

namespace ru\timmson\FruitMamangement\dao;


/**
 * Interface TaskDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface TaskDAO
{
    /**
     * @return array
     */
    function getColumns(): array;

    /**
     * @param int $id
     * @return mixed
     */
    public function getTaskById(int $id);

    /**
     * @param string $name
     * @return mixed
     */
    public function getTaskByName(string $name);

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function getAllTasks(array $filter = [], array $order = []): array;

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function getTasksInProgress(array $filter = [], array $order = []): array;

    /**
     * @param string $user
     * @return array
     */
    public function getSubscribedTaskByUser(string $user): array;
}