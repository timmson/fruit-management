<?php


namespace ru\timmson\FruitMamangement\service;

use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimesheetDAO;
use ru\timmson\FruitMamangement\dao\UserDAO;

/**
 * Class UserService
 * @package ru\timmson\FruitMamangement\service
 */
class UserService
{
    private TimesheetDAO $timesheetDAO;
    private TaskDAO $taskDAO;
    private UserDAO $userDAO;

    /**
     * UserService constructor.
     * @param TimesheetDAO $timesheetDAO
     * @param TaskDAO $taskDAO
     * @param UserDAO $userDAO
     */
    public function __construct(TimesheetDAO $timesheetDAO, TaskDAO $taskDAO, UserDAO $userDAO)
    {
        $this->timesheetDAO = $timesheetDAO;
        $this->taskDAO = $taskDAO;
        $this->userDAO = $userDAO;
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

        $data = [];
        $data[] = $this->userDAO->getUserByName($request["user"]);

        $infos = [];
        for ($i = 0; $i < count($data); $i++) {
            $info = [];
            $info["label"] = $data[$i]["fm_descr"];
            $info["value"] = $data[$i]["fm_name"];
            $infos[] = $info;
        }

        $view["users_json"] = json_encode($infos);
        return $view;
    }
}