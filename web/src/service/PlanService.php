<?php

namespace ru\timmson\FruitManagement\service;

use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\http\Session;
use ru\timmson\FruitManagement\util\Calendar;

class PlanService implements Service
{


    private Session $session;
    private TaskDAO $taskDAO;

    /**
     * PlanService constructor.
     * @param TaskDAO $taskDAO
     * @param Session $session
     */
    public function __construct(TaskDAO $taskDAO, Session $session)
    {
        $this->taskDAO = $taskDAO;
        $this->session = $session;
    }


    /**
     * @inheritDoc
     */
    public function sync(array $request, string $user): array
    {
        $view = [];

        $release = $this->taskDAO->findAllInProgress(["fm_project" => "REL"], ["id" => "asc"]);
        if (isset($request['release']) && strlen($request['release']) > 0) {
            $relId = $request['release'];
        } else if ($this->session->contains('release') && strlen($this->session->get('release')) > 0) {
            $relId = $this->session->get('release');
        } else {
            $relId = $release[0]['id'];
        }

        $this->session->set('release', $relId);
        $view["release"] = $release;
        $view["relid"] = $relId;

        $query = 'select t.fm_user, sum(fm_plan_hour) as fm_plan_hour, sum(fm_all_hour) as fm_all_hour 
			from v_task_in_progress t, fm_relation r 
			where r.fm_parent in (select p.fm_child from fm_relation p where p.fm_parent = ' . $relId . ') 
			and r.fm_child = t.id group by t.fm_user';
        $tasks = $this->taskDAO->executeQuery($query, [], []);

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
                $borderend = Calendar::getTaskEnd($border, $length);

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

        $monthcal = Calendar::getMonthCalendar($plandate);
        $view["monthcal"] = $monthcal;

        $query = " (select t.*, r1.fm_parent as fm_parent from fm_relation r1, v_task_all t ";
        $query .= " where r1.fm_parent = " . $relId . " and t.id = r1.fm_child) ";
        $query .= " union ";
        $query .= " (select t.*, r2.fm_parent as fm_parent from fm_relation r1, fm_relation r2, v_task_all t ";
        $query .= " where r1.fm_parent = " . $relId . " and r2.fm_parent = r1.fm_child and t.id = r2.fm_child) order by fm_state_name, fm_priority";
        $temp = $this->taskDAO->executeQuery($query, [], []);
        $structtasks = array();

        for ($i = 0; $i < count($temp); $i++) {
            if ($temp[$i]['fm_parent'] == $relId) {
                $structtasks[] = $temp[$i];
            }
        }

        for ($i = 0; $i < count($temp); $i++) {
            if ($temp[$i]['fm_parent'] != $relId) {
                for ($j = 0; $j < count($structtasks); $j++) {
                    if ($temp[$i]['fm_parent'] == $structtasks[$j]['id']) {
                        $structtasks[$j]['child'][] = $temp[$i];
                    }
                }
            }
        }

        $view["structtasks"] = $structtasks;

        return $view;
    }

    /**
     * @inheritDoc
     */
    public function async(array $request, string $user): array
    {
        return $this->sync($request, $user);
    }
}


