<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class mysqli_wrapper
 * Mock for mysqli
 * @package ru\timmson\FruitMamangement\dao
 */
class mysqli_wrapper
{
    private array $queries = array();

    /**
     * @param $query
     * @return object|bool
     */
    public function query($query): ?object
    {
        return $this->queries[$query];
    }

    /**
     * @param $query
     * @param $result
     * @return void
     */
    public function addQueryAndResult($query, $result): void
    {
        $this->queries[$query] = new mysqli_result_wrapper($result);
    }

}


/**
 * Class mysqli_result_wrapper
 * @package ru\timmson\FruitMamangement\dao
 */
class mysqli_result_wrapper
{

    private array $result;

    private int $cursor = 0;

    /**
     * mysqli_result_wrapper constructor.
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function fetch_assoc()
    {
        return $this->cursor < count($this->result) ? $this->result[$this->cursor++] : null;
    }

}