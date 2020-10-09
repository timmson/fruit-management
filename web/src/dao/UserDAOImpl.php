<?php


namespace ru\timmson\FruitMamangement\dao;


/**
 * Class UserDAOImpl
 * @package ru\timmson\FruitMamangement\dao
 */
class UserDAOImpl extends AbstractDAO implements UserDAO
{

    public function getUserByName(string $name): array
    {
        return $this->executeQuery("select * from fm_user", ["fm_name" => $name], [])[0];
    }

    protected function getColumns(): array
    {
        return [];
    }
}