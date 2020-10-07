<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class AbstractDAO
 *
 * @package ru\timmson\FruitMamangement\dao
 */
abstract class AbstractDAO
{

    private object $mysqli;

    /**
     * AbstractDAO constructor.
     * @param $mysqli
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * @return array
     */
    abstract function getColumns(): array;

    /**
     * @param string $query
     * @param array $filter
     * @param array $order
     * @return array
     */
    final function executeQuery(string $query, array $filter, array $order)
    {

        $query = $this->buildQuery($query, $filter, $order);

        $result = $this->mysqli->query($query);

        $data = array();

        while (method_exists($result, "fetch_assoc") && $row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
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
                $orderQuery[] = " " . $name . (strlen($value) > 0 ? " " . $value : "");
            }
            $query .= " order by" . implode(",", $orderQuery);
        }

        return $query;
    }

}