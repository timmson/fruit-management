<?
$conn = $CORE->getConnection($currentdep['props']);

$week=isset($_REQUEST['week'])?$_REQUEST['week']:date('W');

$query = 'select t.*, (select group_concat(distinct tm_comment separator \'<br/>\') from tm_work_log where tm_task = t.id and tm_user=\''.$_SESSION['user']['samaccountname'].'\' and week(tm_date) = '.$week.' and tm_spent_hour > 0) as tm_last_comment from v_task_all t where t.tm_project_id <> 4 and t.id in (
select distinct l.tm_task from  tm_work_log l where tm_user=\''.$_SESSION['user']['samaccountname'].'\' and week(l.tm_date) = '.$week.' and tm_spent_hour > 0) order by tm_project_id';

$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("data", $data);



$query = 'select * from v_task_in_progress where tm_project <> \'COMMON\' and (tm_state_name = \'planned\' 
	or tm_state_name = \'in_progress\') and tm_user = \''.$_SESSION['user']['samaccountname'].'\'';
$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("plandata", $data);

$query = 'select * from v_task_in_progress where tm_project <> \'COMMON\' and tm_state_name = \'in_progress\' 
	and id not in (select distinct l.tm_task from  tm_work_log l 
	where week(l.tm_date) ='.$week.') and tm_user = \''.$_SESSION['user']['samaccountname'].'\'';
$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("undata", $data);



$CORE->closeConnection($conn)
?>
