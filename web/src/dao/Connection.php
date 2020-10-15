<?php


namespace ru\timmson\FruitMamangement\dao;


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
     */
    public function query(string $query): array;

    /**
     *  Close connection
     */
    public function close(): void;

}