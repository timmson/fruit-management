<?php


namespace ru\timmson\FruitManagement\dao;

/**
 * Class TimesheetDAO
 * @package ru\timmson\FruitManagement\dao
 */
class TimesheetDAOImpl extends AbstractDAO implements TimeSheetDAO
{

    /**
     * @inheritDoc
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