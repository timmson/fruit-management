<?php


namespace ru\timmson\FruitManagement\service;

use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\Session;

/**
 * Class Agile1Service
 * @package ru\timmson\FruitManagement\service
 */
class AgileService implements Service
{


    /**
     * @var TaskDAO
     */
    private TaskDAO $taskDAO;

    private Session $session;

    /**
     * AgileService constructor.
     * @param TaskDAO $taskDAO
     * @param Session $session
     */
    public function __construct(TaskDAO $taskDAO, Session $session)
    {
        $this->taskDAO = $taskDAO;
        $this->session = $session;
    }


    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function sync(array $request, string $user): array
    {
        $view = [];

        $backlogId = 1;

        $release = $this->taskDAO->findAllInProgress(["fm_project" => "REL"], ["id" => "asc"]);
        if (isset($request['release']) && strlen($request['release']) > 0) {
            $releaseId = $request['release'];
        } else if ($this->session->contains('release') && strlen($this->session->get('release')) > 0) {
            $releaseId = $this->session->get('release');
        } else {
            $releaseId = $release[0]['id'];
        }

        $this->session->set('release', $releaseId);
        $view["release"] = $release;
        $view["relid"] = $releaseId;

        if (isset($request['oper'])) {
            $taskId = $request['task'];
            $toId = $request['toid'];
            $query = 'select r1.fm_parent as id from fm_relation r1, fm_relation r2 where r1.fm_child = ' . $taskId . ' and r2.fm_parent = ' . $releaseId . ' and r1.fm_parent = r2.fm_child';
            $fromId = $this->taskDAO->executeQuery($query, [], []);
            $fromId = (strlen($fromId[0]['id']) > 0) ? $fromId[0]['id'] : $backlogId;
            if ($request['oper'] == 'plan') {
                $this->taskDAO->changeParent($taskId, $fromId, $toId);
            } else if ($request['oper'] == 'state') {
                $this->taskDAO->updateStatus($taskId, $toId);
            }
        }

        $query = " (select t.*, r1.fm_parent as fm_parent from fm_relation r1, v_task_all t ";
        $query .= " where r1.fm_parent = $releaseId and t.id = r1.fm_child) ";
        $query .= " union ";
        $query .= " (select t.*, r2.fm_parent as fm_parent from fm_relation r1, fm_relation r2, v_task_all t ";
        $query .= " where r1.fm_parent = $releaseId and r2.fm_parent = r1.fm_child and t.id = r2.fm_child) order by fm_priority, id";
        $temp = $this->taskDAO->executeQuery($query, [], []);
        $structTasks = array();


        for ($i = 0; $i < count($temp); $i++) {
            if ($temp[$i]['fm_parent'] == $releaseId) {
                $structTasks[] = $temp[$i];
            }
        }

        for ($i = 0; $i < count($temp); $i++) {
            if ($temp[$i]['fm_parent'] != $releaseId) {
                for ($j = 0; $j < count($structTasks); $j++) {
                    if ($temp[$i]['fm_parent'] == $structTasks[$j]['id']) {
                        $structTasks[$j]['child'][] = $temp[$i];
                    }
                }
            }
        }
        $view["structtasks"]=$structTasks;

        $backlog = $this->taskDAO->findAllByParentId($backlogId);
        $view["backlog"]=$backlog;
        $view["backlogid"]=$backlogId;

        return $view;
    }

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function async(array $request, string $user): array
    {
        return $this->sync($request, $user);
    }
}