<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class SubscriberDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class SubscriberDAO extends AbstractDAO
{
    /**
     * @param int $id
     * @return array
     */
    public function getSubscribersByTaskId(int $id)
    {

        $query = "select * from fm_subscribe";

        return $this->executeQuery($query, ["fm_task" => $id], []);

    }

    function getColumns(): array
    {
        return [];
    }

    /**
     * @param int $id
     * @param string $name
     */
    public function subscribe(int $id, string $name): void
    {
        $query = "insert into fm_subscribe values(null, $id, '$name')";

        $this->executeQuery($query, [], []);
    }

    /**
     * @param int $id
     * @param string $name
     */
    public function unsubscribe(int $id, string $name): void
    {
        $query = "delete from fm_subscribe where fm_user ='$name' and fm_task = $id";

        $this->executeQuery($query, [], []);
    }
}