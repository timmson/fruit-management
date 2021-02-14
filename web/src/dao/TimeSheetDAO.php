<?php


namespace ru\timmson\FruitManagement\dao;

/**
 * Interface TimeSheetDAO
 * @package ru\timmson\FruitManagement\dao
 */
interface TimeSheetDAO
{

    /**
     * @param $user
     * @return array
     */
    public function getCurrentWeekTimeSheetByUser($user): array;

}