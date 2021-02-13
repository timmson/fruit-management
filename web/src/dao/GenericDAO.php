<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Interface GenericDAO
 * @package ru\timmson\FruitManagement\dao
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