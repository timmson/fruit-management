<?php


namespace ru\timmson\FruitManagement\dao;

/**
 * Class SubscriberDAO
 * @package ru\timmson\FruitManagement\dao
 */
class SubscriberDAOImpl extends AbstractDAO implements SubscriberDAO
{
    /**
     * @inheritDoc
     */
    public function getSubscribersByTaskId(int $id)
    {

        $query = "select * from fm_subscribe";

        return $this->executeQuery($query, ["fm_task" => $id], []);

    }

    /**
     * @inheritDoc
     */
    function getColumns(): array
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function subscribe(int $id, string $name): void
    {
        $query = "insert into fm_subscribe values(null, $id, '$name')";

        $this->executeQuery($query, [], []);
    }

    /**
     * @inheritDoc
     */
    public function unsubscribe(int $id, string $name): void
    {
        $query = "delete from fm_subscribe where fm_user ='$name' and fm_task = $id";

        $this->executeQuery($query, [], []);
    }
}