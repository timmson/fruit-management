<?php


namespace ru\timmson\FruitMamangement\service;

use Core;
use ru\timmson\FruitMamangement\dao\GenericDAO;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimesheetDAO;

/**
 * Class HomeService - service for home tab
 * @package ru\timmson\FruitMamangement\service
 */
class HomeService implements Service
{

    private TimesheetDAO $timesheetDAO;

    private TaskDAO $taskDAO;

    private GenericDAO $genericDAO;

    public function __construct(
        GenericDAO $genericDAO,
        TimesheetDAO $timesheetDAO,
        TaskDAO $taskDAO
    )
    {
        $this->genericDAO = $genericDAO;
        $this->timesheetDAO = $timesheetDAO;
        $this->taskDAO = $taskDAO;
    }

    public function sync(array $request, string $user): array
    {
        $view = [];

        $timesheet = $this->timesheetDAO->getCurrentWeekTimesheetByUser($user);
        $week = strlen($request['week']) > 0 ? $request['week'] : date('W');
        $view["timesheet"] = $timesheet;

        $tasks = $this->taskDAO->getTasksInProgress(["fm_user" => $user], ["fm_priority" => "", "id" => ""]);
        $view["tasks"] = $tasks;

        $subcribe_tasks = $this->taskDAO->getSubscribedTaskByUser($user);
        $view["subcribe_tasks"] = $subcribe_tasks;

        $border = time();
        $plantasks = array();
        $j = 0;

        $plandatestr = strlen($request['plandate']) > 0 ? $request['plandate'] : date('d.m.Y');
        $plandate = strtotime($plandatestr);
        $month = date("mY", $plandate);

        for ($i = 0; $i < count($tasks); $i++) {
            $length = $tasks[$i]['fm_plan_hour'] - $tasks[$i]['fm_all_hour'];
            if ($length > 0) {

                $borderstart = $border;
                $borderend = getTaskEnd($border, $length);
                $border = $borderend;

                if (date("mY", $borderstart) == $month) {
                    $tasks[$i]['fm_plan_start'] = date("d", $borderstart);
                    if (date("mY", $borderend) == $month) {
                        $tasks[$i]['fm_plan_end'] = date("d", $borderend);
                    } else {
                        $tasks[$i]['fm_plan_end'] = 31;
                    }
                    $plantasks[$j++] = $tasks[$i];
                } else {
                    if (date("mY", $borderend) == $month) {
                        $tasks[$i]['fm_plan_start'] = 1;
                        $tasks[$i]['fm_plan_end'] = date("d", $borderend);
                        $plantasks[$j++] = $tasks[$i];
                    }
                }
            }
        }

        $view["plantasks"] = $plantasks;

        $monthcal = getMonthCalendar($plandate);
        $view["monthcal"] = $monthcal;

        return $view;
    }

    public function async(array $request, string $user):array
    {
        $view = [];

        $view["activity"] = $this->genericDAO->getActivity($user);

        return $view;
    }

}