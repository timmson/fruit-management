<?php


namespace ru\timmson\FruitMamangement\dao;


use Exception;

interface Connection
{

    /**
     * Connection constructor.
     * @param string|null $host
     * @param string|null $port
     * @param string|null $user
     * @param string|null $password
     * @param string|null $database
     */
    public function __construct(string $host = null,  string $port = null, string $user = null, string $password = null, string $database = null);

    /**
     * Return results of $query
     *
     * @param string $query
     * @return array
     * @throws Exception
     */
    public function query(string $query): array;

    /**
     * @return int
     */
    public function getInsertId(): int;

    /**
     *  Close connection
     */
    public function close(): void;

}