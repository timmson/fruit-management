<?
require_once('./lib/calendar.inc.php');

$conn = $CORE->getConnection($currentdep['props']);

$user = $_SESSION['user']['samaccountname']; 

if ($_REQUEST['mode']=='async') {

	$query = 'select * from (select l.*, datediff(curdate(), tm_date) as tm_days_ago, 
	t.tm_name, t.tm_descr from tm_work_log l, v_task_all t where t.id = l.tm_task and l.tm_user <> \''.$user.'\' 
	order by l.tm_date desc, l.id desc)   a where a.tm_days_ago > -1 and a.tm_days_ago < 5 limit 15 ';
	$activity = $CORE->executeQuery($conn, $query);
	$VIEW->assign("activity", $activity);

} else {
	
	$week = strlen($_REQUEST['week'])>0?$_REQUEST['week']:date('W');
	$query = 'select * from tm_timesheet where work_user = \''.$user.'\' and  work_week = week(now()) and work_year = year(now()) ';
	$timesheet = $CORE->executeQuery($conn, $query);
	$VIEW->assign("timesheet", $timesheet);

	$query = 'select * from v_task_in_progress where tm_user = \''.$user.'\' order by tm_priority, id';
	$tasks = $CORE->executeQuery($conn, $query);
	$VIEW->assign("tasks", $tasks);

	$query = 'select t.* from v_task_all t, tm_subscribe s where s.tm_task = t.id and s.tm_user = \''.$user.'\'';
	$subcribe_tasks = $CORE->executeQuery($conn, $query);
	$VIEW->assign("subcribe_tasks", $subcribe_tasks);

	$border = time();
	$plantasks = array();
	$j = 0;

	$plandatestr = strlen($_REQUEST['plandate'])>0?$_REQUEST['plandate']:date('d.m.Y');
	$plandate =strtotime($plandatestr);
	$month = date("mY", $plandate);

	for ($i=0; $i<count($tasks); $i++) {
		$length = $tasks[$i]['tm_plan_hour']-$tasks[$i]['tm_all_hour'];
		if ($length>0) {
	
			$borderstart = $border;
			$borderend = getTaskEnd($border, $length);
			$border = $borderend;

			if (date("mY", $borderstart)==$month) {
				$tasks[$i]['tm_plan_start'] = date("d", $borderstart);
				if (date("mY", $borderend)==$month) {
					$tasks[$i]['tm_plan_end'] = date("d", $borderend);
				} else {
					$tasks[$i]['tm_plan_end'] = 31;
				}
				$plantasks[$j++] = $tasks[$i];
			} else {
				if (date("mY", $borderend)==$month) {
					$tasks[$i]['tm_plan_start'] = 1;
					$tasks[$i]['tm_plan_end'] = date("d", $borderend);
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

