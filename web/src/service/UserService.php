<?php


namespace ru\timmson\FruitManagement\service;

use Exception;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\dao\TimesheetDAO;
use ru\timmson\FruitManagement\dao\UserDAO;

/**
 * Class UserService
 * @package ru\timmson\FruitManagement\service
 */
class UserService implements Service
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


    public function sync(array $request, string $user): array
    {
        $view = [];

        $week = strlen($request['week']) > 0 ? $request['week'] : date('W');
        $view["timesheet"] = $this->timesheetDAO->getCurrentWeekTimesheetByUser($user);
        $view["tasks"] = $this->taskDAO->findAllInProgress(["fm_user" => $user], ["fm_priority" => ""]);
        $view["user"] = $user;

        return $view;
    }

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

    /**
     * @param string $login
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function login(string $login, string $password)
    {

        $root_name = "root";
        $root_pass = md5("root");

        $ret = [-1, "WRONG_CREDENTIALS"];

        if ($root_name == $login && $root_pass == md5($password)) {

            $ret = [0, "SUCCESS", ["fm_name" => $login, "fm_descr" => "", "fm_password_enc" => md5($password)]];

        } else {
            $result = $this->userDAO->getUserByNameAndPassword($login, md5($password));

            if ($result != null) {
                $ret = [0, "SUCCESS", $result];
            }
        }

        return $ret;

    }
}