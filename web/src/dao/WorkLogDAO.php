<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Interface WorkLogDAO
 * @package ru\timmson\FruitManagement\dao
 */
interface WorkLogDAO
{
    /**
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function getActivity(string $user): array;

    /**
     * @param string $project
     * @return array
     * @throws Exception
     */
    public function getWorkedLog(string $project): array;

}