<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class TimesheetDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TimesheetDAOImpl extends AbstractDAO implements TimeSheetDAO
{

    /**
     * @param $user
     * @return array
     */
    public function getCurrentWeekTimeSheetByUser($user): array
    {
        $query = "select * from fm_timesheet where work_user = '$user' and work_week = week(now()) and work_year = year(now())";

        return $this->executeQuery($query, [], []);
    }

    /**
     * @return array
     */
    function getColumns(): array
    {
        return [];
    }
}