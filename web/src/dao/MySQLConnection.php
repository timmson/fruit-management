<?php


namespace ru\timmson\FruitMamangement\dao;


use mysqli_result;

class MySQLConnection implements Connection
{
    private $connection;


    /**
     * @inheritDoc
     */
    public function __construct(string $host = null, string $port = null, string $user = null, string $password = null, string $database = null)
    {
        $this->connection = mysqli_connect($host, $user, $password, $database, $port);
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
    public function close(): void
    {
        mysqli_close($this->connection);
    }
}