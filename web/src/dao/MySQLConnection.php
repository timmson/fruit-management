<?php


namespace ru\timmson\FruitManagement\dao;

use mysqli;
use mysqli_result;

class MySQLConnection implements Connection
{
    private $connection;


    /**
     * @inheritDoc
     */
    public function __construct(string $host = null, string $port = null, string $user = null, string $password = null, string $database = null)
    {
        $this->connection = new mysqli($host, $user, $password, $database, $port);
    }

    /**
     * @inheritDoc
     */
    public function query(string $query): array
    {
        $result = $this->connection->query($query);

        $data = [];

        if ($result instanceof mysqli_result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getInsertId(): int
    {
        return mysqli_insert_id($this->connection);
    }


    /**
     * @inheritDoc
     */
    public function close(): void
    {
        mysqli_close($this->connection);
    }
}