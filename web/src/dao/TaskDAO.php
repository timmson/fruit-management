<?php

namespace ru\timmson\FruitManagement\dao;


/**
 * Interface TaskDAO
 * @package ru\timmson\FruitManagement\dao
 */
interface TaskDAO
{
    /**
     * @return array
     */
    function getColumns(): array;

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id): array;

    /**
     * @param string $name
     * @return array
     */
    public function findByName(string $name): array;

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function findAll(array $filter = [], array $order = []): array;

    /**
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function findAllInProgress(array $filter = [], array $order = []): array;

    /**
     * @param string $user
     * @return array
     */
    public function findAllBySubscribedUser(string $user): array;

    /**
     * @param int $id
     * @return array
     */
    public function findAllByParentId(int $id): array;

    /**
     * @param int $id
     * @param int $fromId
     * @param int $toId
     */
    public function changeParent(int $id, int $fromId, int $toId): void;

    /**
     * @param int $id
     * @param string $statusName
     */
    public function updateStatus(int $id, string $statusName) : void;

    /**
     * @param array $task
     * @return array
     */
    public function create(array $task) : array;

    /**
     * Temporary method
     *
     * @param string $query
     * @param array $filter
     * @param array $order
     * @return array
     */
    public function executeQuery(string $query, array $filter, array $order): array;
}