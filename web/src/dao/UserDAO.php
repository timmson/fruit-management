<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Interface UserDAO
 * @package ru\timmson\FruitManagement\dao
 */
interface UserDAO
{

    /**
     * @param string $name
     * @return array|null
     * @throws Exception
     */
    public function searchUsersByName(string $name): ?array;

    /**
     * @param string $name
     * @param string $password
     * @return array|null
     * @throws Exception
     */
    public function getUserByNameAndPassword(string $name, string $password): ?array;

}