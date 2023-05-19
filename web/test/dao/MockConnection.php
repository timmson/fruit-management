<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Class mysqli_wrapper
 * Mock for mysqli
 * @package ru\timmson\FruitManagement\dao
 */
class MockConnection implements Connection
{
    private array $queries = array();

    private array $results = array();

    private int $insertedId;

    public function __construct(string $host = null, string $port = null, string $user = null, string $password = null, string $database = null)
    {

    }

    public function query($query): array
    {
        if (count($this->queries) > 0) {
            if (!array_key_exists($query, $this->queries)) {
                throw new Exception("Query [" . $query . "] is not expected. Expected queries: [" . json_encode($this->queries) . "]");
            }
            return $this->queries[$query];
        }

        return array_shift($this->results);
    }

    public function addQueryAndResult(string $query, array $result): MockConnection
    {
        $this->queries[$query] = $result;
        return $this;
    }

    public function addResult(array $result): MockConnection
    {
        $this->results[] = $result;
        return $this;
    }

    public function getInsertId(): int
    {
        return $this->insertedId;
    }

    public function setInsertedId(int $insertedId): void
    {
        $this->insertedId = $insertedId;
    }

    public function close(): void
    {

    }
}
