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
        return $this->executeQuery("select * from fm_cat_log order by id");
    }

    /**
     * @return array
     */
    function getColumns(): array
    {
        return [];
    }
}