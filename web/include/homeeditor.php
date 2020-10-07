<?
$conn = $CORE->getConnection();

$user = $_SESSION['user']['samaccountname'];

if ($_REQUEST['mode']=='async') {

	$query = 'select * from (select l.*, datediff(curdate(), fm_date) as fm_days_ago, 
	t.fm_name, t.fm_descr from fm_work_log l, v_task_all t where t.id = l.fm_task and l.fm_user <> \''.$user.'\' 
	order by l.fm_date desc, l.id desc)   a where a.fm_days_ago > -1 and a.fm_days_ago < 5 limit 15 ';
	$activity = $CORE->executeQuery($conn, $query);
	$VIEW->assign("activity", $activity);

} else {
	$timesheetDAO = new \ru\timmson\FruitMamangement\dao\TimesheetDAO($conn);
	$taskDAO = new \ru\timmson\FruitMamangement\dao\TaskDAO($conn);

	$week = strlen($_REQUEST['week'])>0?$_REQUEST['week']:date('W');
	$timesheet = $timesheetDAO->getCurrentWeekTimesheetByUser($user);
	$VIEW->assign("timesheet", $timesheet);

    $tasks = $taskDAO -> getTasksInProgress(["fm_user" => $user], ["fm_priority" => "", "id" => ""]);
    $VIEW->assign("tasks", $tasks);

	$subcribe_tasks = $taskDAO ->getSubscribedTaskByUser($user);
	$VIEW->assign("subcribe_tasks", $subcribe_tasks);

	$border = time();
	$plantasks = array();
	$j = 0;

	$plandatestr = strlen($_REQUEST['plandate'])>0?$_REQUEST['plandate']:date('d.m.Y');
	$plandate =strtotime($plandatestr);
	$month = date("mY", $plandate);

	for ($i=0; $i<count($tasks); $i++) {
		$length = $tasks[$i]['fm_plan_hour']-$tasks[$i]['fm_all_hour'];
		if ($length>0) {

			$borderstart = $border;
			$borderend = getTaskEnd($border, $length);
			$border = $borderend;

			if (date("mY", $borderstart)==$month) {
				$tasks[$i]['fm_plan_start'] = date("d", $borderstart);
				if (date("mY", $borderend)==$month) {
					$tasks[$i]['fm_plan_end'] = date("d", $borderend);
				} else {
					$tasks[$i]['fm_plan_end'] = 31;
				}
				$plantasks[$j++] = $tasks[$i];
			} else {
				if (date("mY", $borderend)==$month) {
					$tasks[$i]['fm_plan_start'] = 1;
					$tasks[$i]['fm_plan_end'] = date("d", $borderend);
					$plantasks[$j++] = $tasks[$i];
				}
			}
		}
	}

	$VIEW->assign("plantasks", $plantasks);

	$monthcal = getMonthCalendar($plandate);
	$VIEW->assign("monthcal", $monthcal);


}
$CORE->closeConnection($conn);
?>

