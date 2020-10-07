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
     * @param $query
     * @param $filter
     * @return array
     */
    final function executeQuery($query, $filter = [])
    {

        if (count($filter) > 0 ) {
            $query.= " where";
        }

        $columns = $this->getColumns();

        foreach ($filter as $name => $value) {
            $query .= " " . $name . " = " . (array_key_exists($name, $columns) && $columns[$name] == "string" ? "'" . $value . "'" : $value);
        }

        $result = $this->mysqli->query($query);

        $data = array();

        while (method_exists($result, "fetch_assoc") && $row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

    /**
     * @return array
     */
    abstract function getColumns(): array;

}