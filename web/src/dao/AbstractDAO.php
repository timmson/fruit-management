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
     * @return array
     */
    final function executeQuery($query)
    {
        $result = $this->mysqli->query($query);

        $data = array();

        while (method_exists($result, "fetch_assoc") && $row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        return $data;
    }

}