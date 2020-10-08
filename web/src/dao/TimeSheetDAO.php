<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Interface TimeSheetDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface TimeSheetDAO
{

    /**
     * @param $user
     * @return array
     */
    public function getCurrentWeekTimeSheetByUser($user): array;

}