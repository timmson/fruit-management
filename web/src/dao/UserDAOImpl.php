<?php


namespace ru\timmson\FruitManagement\dao;


/**
 * Class UserDAOImpl
 * @package ru\timmson\FruitManagement\dao
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
        $users = $this->executeQuery("select * from fm_user", ["fm_name" => $name, "fm_password_enc" => $password], []);
        return empty($users) ? array() : $users[0];
    }

    /**
     * @inheritDoc
     */
    protected function getColumns(): array
    {
        return ["fm_name" => "string", "fm_password_enc" => "string"];
    }
}