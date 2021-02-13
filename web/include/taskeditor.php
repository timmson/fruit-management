<?

use ru\timmson\FruitMamangement\dao\LogCategoryDAO;
use ru\timmson\FruitMamangement\dao\SubscriberDAO;
use ru\timmson\FruitMamangement\dao\TaskDAO;

$url_prefix = $CORE->configuration['global']['site']."?dep=task&task=";

$conn = $CORE->getConnection();

$subscriberDAO = $container->get(SubscriberDAO::class);
$taskDAO = $container->get(TaskDAO::class);

if (in_array($_REQUEST['oper'], array('json', 'update', 'search', 'tasks'))) {
	$taskid = $_REQUEST['task'];
	switch($_REQUEST['oper']) {
		case 'search': $data = $CORE->search($_REQUEST['user']);
					   $infos = array();
					   for ($i = 0; $i < count($data) ;$i++) {
					   		$info = array();
					  		$info['label'] = $data[$i]['cn'].' ('.$data[$i]['department'].')';
   		        			$info['value'] = $data[$i]['samaccountname'];
   		        			$infos[] = $info;
					   }
					   echo json_encode($infos);
					   break;
		case 'tasks':
					$query = "select * from v_task_all ";
					$query .=" where id <> ".$taskid." and concat(fm_name,fm_code,fm_descr) like '%".$_REQUEST['search']."%' ";
					$query .=" order by id, fm_project_id desc";
			$data = $CORE->executeQuery($conn, $query);
					$newdata = array();
					for ($i=0; $i<count($data); $i++) {
						$newdata[] = array(
							'label' => $data[$i]['fm_name'].' '.$data[$i]['fm_code'].'.'.$data[$i]['fm_descr'],
							'value' => $data[$i]['fm_name']
						);
					}
					echo json_encode($newdata);
					break;
		case 'json': $data = prepeareData4Graph($CORE, $conn, $taskid);
					$newdata = array();
					for ($i=0; $i<count($data); $i++) {
						$newdata[$i][0] = $data[$i]['day'];
						$newdata[$i][1] = $data[$i]['spent_hours'];
					}
					echo json_encode($newdata);
					break;
		case 'update' :
					if ((isset($_REQUEST['fname']))&&(isset($_REQUEST['fvalue']))) {
						$fname = $_REQUEST['fname'];
						if ($fname == 'fm_subscribe') {
							toggleSubscribe($subscriberDAO, $taskid, $_SESSION['user']['samaccountname'], $_REQUEST['fvalue']);
						} else if ($fname == 'fm_descr_full') {
							file_put_contents("./attachement/".$taskid, $_REQUEST['fvalue']);
						} else {
							$fvalue = is_numeric($_REQUEST['fvalue'])?$_REQUEST['fvalue']:"'".$_REQUEST['fvalue']."'";
							$query = "update fm_task set ".$fname."=".$fvalue." where id =".$taskid;
							$CORE->executeQuery($conn, $query);
						}
						if (($fname=='fm_user')&&($fvalue!=$_SESSION['user']['samaccountname'])) {
							assign($taskDAO, $taskid, $_SESSION['user']);
						}
						if ($fname=='fm_state') {
							notify($CORE, $conn, $taskid, $_SESSION['user']);
						}
					}
					break;
	}
	$CORE->closeConnection($conn);
	exit;
}

$query = "select * from fm_project order by fm_name";
$projects = $CORE->executeQuery($conn, $query);
$VIEW->assign("projects", $projects);


if (strlen($_REQUEST['task'])>0) {
        $taskid = $_REQUEST['task'];
	if (strlen($_REQUEST['oper'])>0) {
	    switch ($_REQUEST['oper']) {
		case 'new' :
			$task = array(
					'fm_name' => $_REQUEST['fm_name'],
					'fm_descr' => $_REQUEST['fm_descr'],
					'fm_project' => $_REQUEST['fm_project'],
					'fm_state' => 1,
					'fm_priority' => ($_REQUEST['fm_priority']!=''?$_REQUEST['fm_priority']:2),
					'fm_plan' => ($_REQUEST['fm_plan']!=''?$_REQUEST['fm_plan']:0),
					'fm_user' => $_SESSION['user']['samaccountname']
			);
			$task = $taskDAO -> create($task);
			toggleSubscribe($subscriberDAO, $task['id'], $_SESSION['user']['samaccountname'], "off");
			header("Location: ?task=".$task['id']);
			break;
		case 'clone' :
			$query = "insert into fm_task ";
			$query .= "select null, fm_name, fm_descr, fm_project, ";
			$query .= "1, fm_priority, 0, '".$_SESSION['user']['samaccountname']."' from fm_task where id = ".$taskid;
			$CORE->executeQuery($conn, $query);
			$taskid = mysqli_insert_id($conn);
			toggleSubscribe($subscriberDAO, $taskid, $_SESSION['user']['samaccountname'], "off");
			header("Location: ?task=".$taskid);
			break;
		case 'add':
			$query = "insert into fm_work_log VALUES(null,";
			$query .= $taskid.", ".$_REQUEST['fm_cat'].",";
			$query .= "str_to_date('".$_REQUEST['fm_date']."', '%d.%m.%Y'), now(),";
			$query .= ($_REQUEST['fm_spent_hour']!==''?$_REQUEST['fm_spent_hour']:0).',';
			$query .= "'".$_REQUEST['fm_comment']."',";
			$query .= "'".$_SESSION['user']['samaccountname']."'";
			$query .= ")";
			$CORE->executeQuery($conn, $query);
			notify($CORE, $conn, $taskid, $_SESSION['user']);
			header("Location: ?task=".$taskid);
		    break;
		case 'addrel':
			if ((isset($_REQUEST['fname']))&&(isset($_REQUEST['fvalue']))) {
				$fname = $_REQUEST['fname'];
				$fvalue = $_REQUEST['fvalue'];
				$data = $taskDAO->findByName($fvalue);
				$fvalue = $data['id'];
				if (is_numeric($fvalue)) {
					$query = "insert into fm_relation values(null,";
					if ($fname=='fm_parent') {
				   		$query .= $fvalue.','.$taskid;
					} else {
				   		$query .= $taskid.','.$fvalue;
					}
					$query .= ")";
					$CORE->executeQuery($conn, $query);
				}
			}
			header("Location: ?task=".$taskid);
		    break;
		case 'delrel':
			$fname = $_REQUEST['fname'];
			$fvalue = $_REQUEST['fvalue'];
			$query = "delete from fm_relation where ";
			if ($fname=='fm_parent') {
				$query .= $fname.'='.$fvalue.' and fm_child='.$taskid;
			} else {
				$query .= $fname.'='.$fvalue.' and fm_parent='.$taskid;
			}
			$CORE->executeQuery($conn, $query);
			header("Location: ?task=".$taskid);
		     break;
		case 'delete':
			$query = "delete from fm_work_log where id =".$_REQUEST['fm_work_id'];
			$CORE->executeQuery($conn, $query);
			header("Location: ?task=".$taskid);
		     break;
	    }
	}

	$task = getTaskInfo($CORE, $conn, $taskid);

	$task['worklog'] = getWorkLog($CORE, $conn, $taskid);

	$task['subscribers'] = $subscriberDAO->getSubscribersByTaskId($taskid);

	$task['fm_descr_full'] = file_get_contents("./attachement/".$taskid);

	$logCategoryDAO = new LogCategoryDAO($conn);
	$task['worklog_cat'] = $logCategoryDAO->getAllOrderById();

	$VIEW->assign("task", $task);

} else {
	$query = "select * from v_task_in_progress ";
	if ($_REQUEST['state']=='all')  {
		$query = "select * from v_task_all ";
	}

	if (strlen($_REQUEST['project'])!='')  {
		$_SESSION['project'] = $_REQUEST['project'];
	}

	$query .= " where 1 = 1 ";

	if ((strlen($_SESSION['project'])!='')&&(($_SESSION['project'])!='all')) {
		$query .= ' and fm_project_id='.$_SESSION['project'];
	}

	if (strlen($_REQUEST['search'])!='') {
			$query .= " and concat(fm_name,fm_code,fm_descr) like '%".$_REQUEST['search']."%' ";
	}

	$query .= ' order by id, fm_project_id desc';
	$tasks = $CORE->executeQuery($conn, $query);
	$VIEW->assign("tasks", $tasks);
}


$CORE->closeConnection($conn);

function getWorkLog($CORE, $conn, $taskid) {
	$query = "select l.*, c.fm_name as fm_cat_name, c.fm_descr as fm_cat_descr from fm_work_log l, fm_cat_log c where fm_task = ".$taskid." and l.fm_cat = c.id order by fm_date,id";
	$temp = $CORE->executeQuery($conn, $query);
	return $temp;
}

function getSubscribers($CORE, $conn, $taskid) {
	$query = "select * from fm_subscribe where fm_task = ".$taskid;
	$temp = $CORE->executeQuery($conn, $query);
	return $temp;
}

function getTaskInfo($CORE, $conn, $taskid) {
	global $url_prefix;

	$query = "select t.*, r.fm_parent, r.fm_child, 'current' as tasktype from v_task_all t, fm_relation r";
	$query.=" where t.id = ".$taskid." and r.id = (select min(id) from fm_relation) or ";
	$query.=" (r.fm_child = ".$taskid." and t.id = r.fm_parent) or ";
	$query.=" (r.fm_parent = ".$taskid." and t.id = r.fm_child) ";
	$temp = $CORE->executeQuery($conn, $query);
	$task = array();

	for ($i=0; $i<count($temp); $i++) {
		if (($taskid==$temp[$i]['id'])&&($temp[$i]['tasktype'])=="current") {
			$task = $temp[$i];
		}
	}

	$task['fm_url'] = urlencode($url_prefix.$taskid);

	for ($i=0; $i<count($temp); $i++) {
		if ($temp[$i]['tasktype']=="current") {
			if ($taskid==$temp[$i]['fm_parent']) {
				$task['child'][] = $temp[$i];
			} else if ($taskid==$temp[$i]['fm_child']) {
				$task['parent'][] = $temp[$i];
			}
		} else if ($temp[$i]['tasktype']=="availible") {
			if ($temp[$i]['fm_project_id']==$temp[$i]['fm_child']) {
				$task['parentav'][] = $temp[$i];
			} else if ($temp[$i]['fm_project_id']==$temp[$i]['fm_parent']) {
				$task['childav'][] = $temp[$i];
			}
		}
	}

	$query = $query = "select id from fm_subscribe where fm_user ='".$_SESSION['user']['samaccountname']."' and fm_task = ".$taskid;
	$subscribe = $CORE->executeQuery($conn, $query);
	$task['fm_subscribe'] = (count($subscribe) > 0)?'on':'off';

	return $task;
}

function toggleSubscribe($subscribeDAO, $taskid, $username, $value):void {
	if ($value == "off") {
		$subscribeDAO->subscribe($taskid, $username);
	} else {
        $subscribeDAO->unsubscribe($taskid, $username);
	}
}

function prepeareData4Graph($CORE, $conn, $taskid) {
	$query = "select sum(fm_spent_hour) as spent_hours, week(fm_date) as day
		 from fm_work_log where fm_task = ".$taskid." and fm_spent_hour>0 group by week(fm_date)";
	$data = $CORE->executeQuery($conn, $query);
	return $data;
}

function notify($CORE, $conn, $taskid, $user) {
		global $url_prefix;
		$query = 'select * from v_task_all where id = '.$taskid;
		$data = $CORE->executeQuery($conn, $query);
		$data = $data[0];
		$subject = $data['fm_name']." The task has changed by ".$user['fio'].".";
		$body =  '['.$data['fm_name'].'] '.$data['fm_descr'].'</a> ';
		$body .= ' The task has changed by '.$user['fio'].'.<br/>URL:&nbsp;'.$url_prefix.$taskid;

		$subscribers = getSubscribers($CORE, $conn, $taskid);
		for ($i=0; $i<count($subscribers); $i++){
			if ($user['samaccountname'] != $subscribers[$i]['fm_user']) {
				$recipient = "i".$subscribers[$i]['fm_user']."@".$CORE->configuration['adauth']['addomain'];
				$CORE->sendmail("no-reply@.$CORE->configuration['adauth']['addomain']", $recipient, $subject, $body);
			}
		}
	}

function assign($taskDAO, $taskid, $user) {
		global $url_prefix;
		$data = $taskDAO->getTaskById($taskid);
		$recipient = "i".$data['fm_user']."@".$CORE->configuration['adauth']['addomain'];
		$subject = $data['fm_name']." has assigned to you by ".$user['fio'];
		$body =  '['.$data['fm_name'].'] '.$data['fm_descr'].'</a> ';
		$body .= ' has assigned to you by <b>'.$user['fio'].'</b>.<br/>URL:&nbsp;'.$url_prefix.$taskid;
		$CORE->sendmail("no-reply@.$CORE->configuration['adauth']['addomain']", $recipient, $subject, $body);
	}

?>
