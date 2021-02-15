<?php


namespace ru\timmson\FruitManagement\dao;

use Exception;

/**
 * Interface TimeSheetDAO
 * @package ru\timmson\FruitManagement\dao
 */
interface TimeSheetDAO
{

    /**
     * @param $user
     * @return array
     * @throws Exception
     */
    public function getCurrentWeekTimeSheetByUser($user): array;

}