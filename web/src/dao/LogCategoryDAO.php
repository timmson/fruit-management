<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Class LogCategoryDAO
 * @package ru\timmson\FruitManagement\dao
 */
class LogCategoryDAO extends AbstractDAO
{

    /**
     * @return array
     * @throws Exception
     */
    public function getAllOrderById()
    {
        $query = "select * from fm_cat_log order by id";

        return $this->executeQuery($query, [] , []);
    }

    /**
     * @return array
     */
    function getColumns(): array
    {
        return [];
    }
}