<?php


namespace ru\timmson\FruitMamangement\service;

use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimesheetDAO;

/**
 * Class UserService
 * @package ru\timmson\FruitMamangement\service
 */
class UserService
{
    private TimesheetDAO $timesheetDAO;
    private TaskDAO $taskDAO;

    /**
     * UserService constructor.
     * @param TimesheetDAO $timesheetDAO
     * @param TaskDAO $taskDAO
     */
    public function __construct(TimesheetDAO $timesheetDAO, TaskDAO $taskDAO)
    {
        $this->timesheetDAO = $timesheetDAO;
        $this->taskDAO = $taskDAO;
    }

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function sync(array $request, string $user): array
    {
        $view = [];

        $week = strlen($request['week']) > 0 ? $request['week'] : date('W');
        $view["timesheet"] = $this->timesheetDAO->getCurrentWeekTimesheetByUser($user);
        $view["tasks"] = $this->taskDAO->getTasksInProgress(["fm_user" => $user], ["fm_priority" => ""]);
        $view["user"] = $user;

        return $view;
    }

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function async(array $request, string $user): array
    {
        $view = [];

/*        $data = $CORE->search($_REQUEST['user']);
        $infos = array();
        for ($i = 0; $i < count($data) ;$i++) {
            $info = array();
            $info['label'] = $data[$i]['cn'].' ('.$data[$i]['department'].')';
            $info['value'] = $data[$i]['samaccountname'];
            $infos[] = $info;
        }*/

        $view["users_json"] = "[]";//json_encode($infos);
        return $view;
    }
}