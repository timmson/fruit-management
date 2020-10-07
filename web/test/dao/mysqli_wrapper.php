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
     * @throws \Exception
     */
    public function query($query): ?object
    {
        if (!array_key_exists($query, $this->queries)) {
            throw new \Exception("Query [" . $query . "] is not expected. Expected queries: [" . json_encode($this->queries) . "]");
        }
        return $this->queries[$query];
    }

    /**
     * @param string $query
     * @param $result
     * @return void
     */
    public function addQueryAndResult(string $query, array $result): void
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