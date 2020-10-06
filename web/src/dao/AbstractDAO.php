<?php


namespace ru\timmson\FruitMamangement\dao;

use mysqli_result;

abstract class AbstractDAO
{

    private $connection;

    /**
     * AbstractDAO constructor.
     * @param $connection
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $query
     * @return array|bool
     */
    final function executeQuery($query)
    {
/*        $result = mysqli_query($this->connection, $query);

        if ($result instanceof mysqli_result) {
            for ($data = array(); $row = $result->fetch_assoc(); $data[] = $row);
        } else {
            $data = $result;
        }

        return $data;*/
        return [0];
    }

}