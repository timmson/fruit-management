<?php


namespace ru\timmson\FruitMamangement\dao;

use Exception;

/**
 * Interface GenericDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface GenericDAO
{
    /**
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function getActivity(string $user): array;

}