<?php


namespace ru\timmson\FruitMamangement\dao;

use Exception;

/**
 * Class mysqli_wrapper
 * Mock for mysqli
 * @package ru\timmson\FruitMamangement\dao
 */
class MockConnection implements Connection
{
    private array $queries = array();

    public function __construct(string $host = null, string $port = null, string $user = null, string $password = null, string $database = null) {

    }

    /**
     * @inheritDoc
     */
    public function query($query): array
    {

        if (!array_key_exists($query, $this->queries)) {
            throw new Exception("Query [" . $query . "] is not expected. Expected queries: [" . json_encode($this->queries) . "]");
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
        $this->queries[$query] = $result;


    }


    public function close(): void
    {

    }
}