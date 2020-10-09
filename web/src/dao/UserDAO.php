<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Interface UserDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface UserDAO
{

    /**
     * @param string $name
     * @return array
     */
    public function getUserByName(string $name): ?array;

}