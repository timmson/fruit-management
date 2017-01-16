<?
require_once('./lib/tasklib.php');
require_once('./lib/svnclient.php');

$url_prefix = $CORE->configuration['global']['site']."?dep=task&task=";

$conn = $CORE->getConnection($currentdep['props']);

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
					$query .=" where id <> ".$taskid." and concat(tm_name,tm_code,tm_descr) like '%".$_REQUEST['search']."%' ";
					$query .=" order by id, tm_project_id desc"; ;
					$data = $CORE->executeQuery($conn, $query);
					$newdata = array();
					for ($i=0; $i<count($data); $i++) {
						$newdata[] = array(
							'label' => $data[$i]['tm_name'].' '.$data[$i]['tm_code'].'.'.$data[$i]['tm_descr'], 
							'value' => $data[$i]['tm_name']
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
						if ($fname == 'tm_subscribe') {
							toggleSubscribe($CORE, $conn, $taskid, $_SESSION['user']['samaccountname'], $_REQUEST['fvalue']);
						} else if ($fname == 'tm_descr_full') {
							file_put_contents("./attachement/".$taskid, $_REQUEST['fvalue']);
						} else {
							$fvalue = is_numeric($_REQUEST['fvalue'])?$_REQUEST['fvalue']:"'".$_REQUEST['fvalue']."'";
							$query = "update tm_task set ".$fname."=".$fvalue." where id =".$taskid;
							$CORE->executeQuery($conn, $query);
						}
						if (($fname=='tm_user')&&($fvalue!=$_SESSION['user']['samaccountname'])) {
							assign($CORE, $conn, $taskid, $_SESSION['user']);
						}
						if ($fname=='tm_state') {
							notify($CORE, $conn, $taskid, $_SESSION['user']);
						} 
					}
					break;
	}
	$CORE->closeConnection($conn);
	exit;
}

$query = "select * from tm_project order by tm_name";
$projects = $CORE->executeQuery($conn, $query);
$VIEW->assign("projects", $projects);


if (strlen($_REQUEST['task'])>0) {
        $taskid = $_REQUEST['task'];
        $taskDAO = new TaskDAO($CORE, $conn); 
	if (strlen($_REQUEST['oper'])>0) {
	    switch ($_REQUEST['oper']) {
		case 'new' : 
			$task = array(
					'tm_name' => $_REQUEST['tm_name'], 
					'tm_descr' => $_REQUEST['tm_descr'],
					'tm_project' => $_REQUEST['tm_project'],
					'tm_state' => 1,
					'tm_priority' => ($_REQUEST['tm_priority']!=''?$_REQUEST['tm_priority']:2),
					'tm_plan' => ($_REQUEST['tm_plan']!=''?$_REQUEST['tm_plan']:0),
					'tm_user' => $_SESSION['user']['samaccountname']
			);
			$task = $taskDAO -> merge($task);
			toggleSubscribe($CORE, $conn, $task['id'], $_SESSION['user']['samaccountname'], "off");
			header("Location: ?task=".$task['id']);
			break;
		case 'clone' :
			$query = "insert into tm_task ";
			$query .= "select null, tm_name, tm_descr, tm_project, ";
			$query .= "1, tm_priority, 0, '".$_SESSION['user']['samaccountname']."' from tm_task where id = ".$taskid;
			$CORE->executeQuery($conn, $query);	
			$taskid = mysql_insert_id($conn);
			toggleSubscribe($CORE, $conn, $taskid, $_SESSION['user']['samaccountname'], "off");
			header("Location: ?task=".$taskid);
			break;
		case 'add': 
			$query = "insert into tm_work_log VALUES(null,";
			$query .= $taskid.", ".$_REQUEST['tm_cat'].",";
			$query .= "str_to_date('".$_REQUEST['tm_date']."', '%d.%m.%Y'), now(),";
			$query .= ($_REQUEST['tm_spent_hour']!==''?$_REQUEST['tm_spent_hour']:0).',';
			$query .= "'".$_REQUEST['tm_comment']."',";
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
				$query = "select id from v_task_all where tm_name ='".$fvalue."'";
				$data = $CORE->executeQuery($conn, $query);
				$fvalue = $data[0]['id'];
				if (is_numeric($fvalue)) {
					$query = "insert into tm_relation values(null,";
					if ($fname=='tm_parent') {
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
			$query = "delete from tm_relation where ";
			if ($fname=='tm_parent') {
				$query .= $fname.'='.$fvalue.' and tm_child='.$taskid;
			} else {
				$query .= $fname.'='.$fvalue.' and tm_parent='.$taskid;
			}
			$CORE->executeQuery($conn, $query);
			header("Location: ?task=".$taskid);
		     break;
		case 'delete': 
			$query = "delete from tm_work_log where id =".$_REQUEST['tm_work_id'];
			$CORE->executeQuery($conn, $query);
			header("Location: ?task=".$taskid);
		     break;
	    }
	}

	$task = getTaskInfo($CORE, $conn, $taskid);
	
	$task['worklog'] = getWorkLog($CORE, $conn, $taskid);
	
	$task['subscribers'] = getSubscribers($CORE, $conn, $taskid);
	
	$task['tm_descr_full'] = file_get_contents("./attachement/".$taskid);

	$svnClient = new SvnClient();
	$task['vcslog'] = $svnClient->getSVNHistory($task['tm_name']);

	$query = "select * from tm_cat_log order by id";
	$task['worklog_cat'] = $CORE->executeQuery($conn, $query);

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
		$query .= ' and tm_project_id='.$_SESSION['project'];	
	}

	if (strlen($_REQUEST['search'])!='') {
			$query .= " and concat(tm_name,tm_code,tm_descr) like '%".$_REQUEST['search']."%' ";
	}
	
	$query .= ' order by id, tm_project_id desc'; 
	$tasks = $CORE->executeQuery($conn, $query);
	$VIEW->assign("tasks", $tasks);
}


$CORE->closeConnection($conn);

function getWorkLog($CORE, $conn, $taskid) {
	$query = "select l.*, c.tm_name as tm_cat_name, c.tm_descr as tm_cat_descr from tm_work_log l, tm_cat_log c where tm_task = ".$taskid." and l.tm_cat = c.id order by tm_date,id";
	$temp = $CORE->executeQuery($conn, $query); 
	return $temp;
}

function getSubscribers($CORE, $conn, $taskid) {
	$query = "select * from tm_subscribe where tm_task = ".$taskid;
	$temp = $CORE->executeQuery($conn, $query); 
	return $temp;
}

function getTaskInfo($CORE, $conn, $taskid) {
	global $url_prefix;
	
	$query = "select t.*, r.tm_parent, r.tm_child, 'current' as tasktype from v_task_all t, tm_relation r"; 
	$query.=" where t.id = ".$taskid." and r.id = (select min(id) from tm_relation) or ";
	$query.=" (r.tm_child = ".$taskid." and t.id = r.tm_parent) or ";
	$query.=" (r.tm_parent = ".$taskid." and t.id = r.tm_child) ";
	$temp = $CORE->executeQuery($conn, $query);
	$task = array();

	for ($i=0; $i<count($temp); $i++) {
		if (($taskid==$temp[$i]['id'])&&($temp[$i]['tasktype'])=="current") {
			$task = $temp[$i];
		}
	}

	$task['tm_url'] = urlencode($url_prefix.$taskid);

	for ($i=0; $i<count($temp); $i++) {
		if ($temp[$i]['tasktype']=="current") {
			if ($taskid==$temp[$i]['tm_parent']) {
				$task['child'][] = $temp[$i];
			} else if ($taskid==$temp[$i]['tm_child']) {
				$task['parent'][] = $temp[$i];
			}
		} else if ($temp[$i]['tasktype']=="availible") {
			if ($temp[$i]['tm_project_id']==$temp[$i]['tm_child']) {
				$task['parentav'][] = $temp[$i];
			} else if ($temp[$i]['tm_project_id']==$temp[$i]['tm_parent']) {
				$task['childav'][] = $temp[$i];
			}
		}
	}

	$query = $query = "select id from tm_subscribe where tm_user ='".$_SESSION['user']['samaccountname']."' and tm_task = ".$taskid;
	$subscribe = $CORE->executeQuery($conn, $query);
	$task['tm_subscribe'] = (count($subscribe) > 0)?'on':'off';

	return $task;
}

function toggleSubscribe($CORE, $conn, $taskid, $username, $value) {
	if ($value=='off') {
		$query = "insert into tm_subscribe values(null,".$taskid.",'".$username."')";
	} else {
		$query = "delete from tm_subscribe where tm_user ='".$username."' and tm_task = ".$taskid;
	}
	return $CORE->executeQuery($conn, $query);
}

function prepeareData4Graph($CORE, $conn, $taskid) {
	$query = "select sum(tm_spent_hour) as spent_hours, week(tm_date) as day
		 from tm_work_log where tm_task = ".$taskid." and tm_spent_hour>0 group by week(tm_date)";
	$data = $CORE->executeQuery($conn, $query);
	return $data;
}

function notify($CORE, $conn, $taskid, $user) {
		global $url_prefix;
		$query = 'select * from v_task_all where id = '.$taskid;
		$data = $CORE->executeQuery($conn, $query);
		$data = $data[0];
		$subject = $data['tm_name']." The task has changed by ".$user['fio'].".";
		$body =  '['.$data['tm_name'].'] '.$data['tm_descr'].'</a> ';
		$body .= ' The task has changed by '.$user['fio'].'.<br/>URL:&nbsp;'.$url_prefix.$taskid;
		
		$subscribers = getSubscribers($CORE, $conn, $taskid); 
		for ($i=0; $i<count($subscribers); $i++){
			if ($user['samaccountname'] != $subscribers[$i]['tm_user']) {
				$recipient = "i".$subscribers[$i]['tm_user']."@".$CORE->configuration['adauth']['addomain'];
				$CORE->sendmail("no-reply@.$CORE->configuration['adauth']['addomain']", $recipient, $subject, $body);
			}
		}
	}

function assign($CORE, $conn, $taskid, $user) {
		global $url_prefix;
		$query = 'select * from v_task_all where id = '.$taskid;
		$data = $CORE->executeQuery($conn, $query);
		$data = $data[0];
		$recipient = "i".$data['tm_user']."@".$CORE->configuration['adauth']['addomain'];
		$subject = $data['tm_name']." has assigned to you by ".$user['fio'];
		$body =  '['.$data['tm_name'].'] '.$data['tm_descr'].'</a> ';
		$body .= ' has assigned to you by <b>'.$user['fio'].'</b>.<br/>URL:&nbsp;'.$url_prefix.$taskid;
		$CORE->sendmail("no-reply@.$CORE->configuration['adauth']['addomain']", $recipient, $subject, $body);
	}

?>
