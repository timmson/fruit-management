<?php


namespace ru\timmson\FruitMamangement\dao;

use Exception;

/**
 * Class AbstractDAO
 *
 * @package ru\timmson\FruitMamangement\dao
 */
abstract class AbstractDAO
{

    protected Connection $connection;

    /**
     * setConnection.
     * @param $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return array
     */
    abstract protected function getColumns(): array;

    /**
     * @param string $query
     * @param array $filter
     * @param array $order
     * @return array
     * @throws Exception
     */
    final function executeQuery(string $query, array $filter, array $order)
    {

        $query = $this->buildQuery($query, $filter, $order);

        return $this->connection->query($query);

    }

    /**
     * @param string $query
     * @param array $filter
     * @param array $order
     * @return string
     */
    private function buildQuery(string $query, array $filter = [], array $order = []): string
    {

        $columns = $this->getColumns();

        if (count($filter) > 0) {

            $filterQuery = [];
            foreach ($filter as $name => $value) {
                $filterQuery [] = " " . $name . " = " . (array_key_exists($name, $columns) && $columns[$name] == "string" ? "'" . $value . "'" : $value);
            }
            $query .= " where" . implode(" and ", $filterQuery);
        }

        if (count($order) > 0) {
            $orderQuery = [];
            foreach ($order as $name => $value) {
                $orderQuery[] = " " . $name . ((strlen($value) > 0) ? " " . $value : "");
            }
            $query .= " order by" . implode(",", $orderQuery);
        }

        return $query;
    }

}