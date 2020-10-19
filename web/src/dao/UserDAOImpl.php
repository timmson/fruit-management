<?php


namespace ru\timmson\FruitMamangement\dao;


/**
 * Class UserDAOImpl
 * @package ru\timmson\FruitMamangement\dao
 */
class UserDAOImpl extends AbstractDAO implements UserDAO
{

    /**
     * @inheritDoc
     */
    public function getUserByName(string $name): ?array
    {
        return $this->executeQuery("select * from fm_user", ["fm_name" => $name], [])[0];
    }

    /**
     * @inheritDoc
     */
    public function getUserByNameAndPassword(string $name, string $password): ?array
    {
        return $this->executeQuery("select * from fm_user", ["fm_name" => $name, "fm_password_enc" => $password], [])[0];
    }

    /**
     * @inheritDoc
     */
    protected function getColumns(): array
    {
        return ["fm_name" => "string", "fm_password_enc" => "string"];
    }
}