<?
require_once('./lib/calendar.inc.php');

$conn = $CORE->getConnection($currentdep['props']);

$query = "select * from v_task_in_progress where fm_project  = 'REL' order by id desc";
$release = $CORE->executeQuery($conn, $query);
if (strlen($_REQUEST['release'])>0) {
	$relid = $_REQUEST['release'];
} else if (strlen($_SESSION['release'])>0) {
	$relid = $_SESSION['release'];
} else {
	$relid = $release[0]['id'];
}

$_SESSION['release'] = $relid;
$VIEW->assign("release", $release);
$VIEW->assign("relid", $relid);

$query = 'select t.fm_user, sum(fm_plan_hour) as fm_plan_hour, sum(fm_all_hour) as fm_all_hour 
			from v_task_in_progress t, fm_relation r 
			where r.fm_parent in (select p.fm_child from fm_relation p where p.fm_parent = '.$relid.') 
			and r.fm_child = t.id group by t.fm_user';
$tasks = $CORE->executeQuery($conn, $query);

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

$query = " (select t.*, r1.fm_parent as fm_parent from fm_relation r1, v_task_all t ";
$query .= " where r1.fm_parent = ".$relid." and t.id = r1.fm_child) ";
$query .= " union ";
$query .= " (select t.*, r2.fm_parent as fm_parent from fm_relation r1, fm_relation r2, v_task_all t ";
$query .= " where r1.fm_parent = ".$relid." and r2.fm_parent = r1.fm_child and t.id = r2.fm_child) order by fm_state_name, fm_priority";
$temp = $CORE->executeQuery($conn, $query);
$structtasks = array();

for ($i=0; $i<count($temp); $i++) {
	if ($temp[$i]['fm_parent']==$relid) {
		$structtasks[] = $temp[$i];
	}
}

for ($i=0; $i<count($temp); $i++) {
	if ($temp[$i]['fm_parent']!=$relid) {
		for ($j=0; $j<count($structtasks); $j++) {
			if ($temp[$i]['fm_parent']==$structtasks[$j]['id']) {
					$structtasks[$j]['child'][] = $temp[$i];
			}
		}
	}
}

$VIEW->assign("structtasks", $structtasks);

$CORE->closeConnection($conn);
?>
