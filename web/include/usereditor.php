<?
$user = strlen($_REQUEST['user'])>0?$_REQUEST['user']:$_SESSION['user']['samaccountname'];

if ($_REQUEST['mode'] == 'async') {
	$data = $CORE->search($_REQUEST['user']);
	$infos = array();
	for ($i = 0; $i < count($data) ;$i++) {
	   		$info = array();
	  		$info['label'] = $data[$i]['cn'].' ('.$data[$i]['department'].')';
   			$info['value'] = $data[$i]['samaccountname'];
   			$infos[] = $info;
	}
	echo json_encode($infos);
	
} else {

	$conn = $CORE->getConnection($currentdep['props']);

	$week = strlen($_REQUEST['week'])>0?$_REQUEST['week']:date('W');
	$timesheetDAO = new \ru\timmson\FruitMamangement\dao\TimesheetDAO($conn);
	$timesheet = $timesheetDAO->getCurrentWeekTimesheetByUser($user);
	$VIEW->assign("timesheet", $timesheet);


	$query = 'select * from v_task_in_progress where fm_user = \''.$user.'\' order by fm_priority';

	$current = $CORE->executeQuery($conn, $query);
	$VIEW->assign("tasks", $current);

	$VIEW->assign("user", $user);

	$CORE->closeConnection($conn);
}
?>
