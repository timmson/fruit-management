<?
$conn = $CORE->getConnection($currentdep['props']);

$week=isset($_REQUEST['week'])?$_REQUEST['week']:date('W');

$query = 'select t.*, (select group_concat(distinct fm_comment separator \'<br/>\') from fm_work_log where fm_task = t.id and fm_user=\''.$_SESSION['user']['samaccountname'].'\' and week(fm_date) = '.$week.' and fm_spent_hour > 0) as fm_last_comment from v_task_all t where t.fm_project_id <> 4 and t.id in (
select distinct l.fm_task from  fm_work_log l where fm_user=\''.$_SESSION['user']['samaccountname'].'\' and week(l.fm_date) = '.$week.' and fm_spent_hour > 0) order by fm_project_id';

$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("data", $data);



$query = 'select * from v_task_in_progress where fm_project <> \'COMMON\' and (fm_state_name = \'planned\' 
	or fm_state_name = \'in_progress\') and fm_user = \''.$_SESSION['user']['samaccountname'].'\'';
$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("plandata", $data);

$query = 'select * from v_task_in_progress where fm_project <> \'COMMON\' and fm_state_name = \'in_progress\' 
	and id not in (select distinct l.fm_task from  fm_work_log l 
	where week(l.fm_date) ='.$week.') and fm_user = \''.$_SESSION['user']['samaccountname'].'\'';
$data = $CORE->executeQuery($conn, $query);
$VIEW->assign("undata", $data);



$CORE->closeConnection($conn)
?>
