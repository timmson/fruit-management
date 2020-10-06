<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Class TimesheetDAO
 * @package ru\timmson\FruitMamangement\dao
 */
class TimesheetDAO extends AbstractDAO
{

    /**
     * @param $user
     * @param $week
     * @param $year
     * @return array|bool|
     */
    public function getTimesheetByWeekAndYear($user, $week, $year)
    {
        $query = "select * from fm_timesheet where work_user = $user and  work_week = $week and work_year = $year";
        return $this->executeQuery($query);
    }
}