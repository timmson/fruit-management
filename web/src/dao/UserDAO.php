<?php


namespace ru\timmson\FruitMamangement\dao;

use Exception;

/**
 * Interface UserDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface UserDAO
{

    /**
     * @param string $name
     * @return array|null
     * @throws Exception
     */
    public function getUserByName(string $name): ?array;

    /**
     * @param string $name
     * @param string $password
     * @return array|null
     * @throws Exception
     */
    public function getUserByNameAndPassword(string $name, string $password): ?array;

}