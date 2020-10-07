<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class LogCategoryDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class LogCategoryDAO extends AbstractDAO
{

    /**
     * @return array
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