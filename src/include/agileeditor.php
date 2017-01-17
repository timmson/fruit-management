<?
require_once('./lib/tasklib.php');
require_once('./lib/rellib.php');

$conn = $CORE->getConnection($currentdep['props']);

$backlogid = 334;

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

if (isset($_REQUEST['oper'])){
	$taskid = $_REQUEST['task'];
	$toid = $_REQUEST['toid'];
	//$query = 'select max(fm_child) as id from fm_relation where fm_parent = '.$relid;
	$query = 'select r1.fm_parent as id from fm_relation r1, fm_relation r2 where r1.fm_child = '.$taskid.' and r2.fm_parent = '.$relid.' and r1.fm_parent = r2.fm_child';
	$fromid = $CORE->executeQuery($conn, $query);
	$fromid = (strlen($fromid[0]['id'])>0)?$fromid[0]['id']:$backlogid;
	$relDao = new RelDAO($CORE, $conn);
	$taskDao = new TaskDAO($CORE, $conn);
	if ($_REQUEST['oper']=='plan') {
		$relDao->move($taskid, $fromid, $toid);		
	} else if ($_REQUEST['oper']=='state') {
		$taskDao->moveTo($taskid, $toid);
	}
}

$query = " (select t.*, r1.fm_parent as fm_parent from fm_relation r1, v_task_all t ";
$query .= " where r1.fm_parent = ".$relid." and t.id = r1.fm_child) ";
$query .= " union ";
$query .= " (select t.*, r2.fm_parent as fm_parent from fm_relation r1, fm_relation r2, v_task_all t ";
$query .= " where r1.fm_parent = ".$relid." and r2.fm_parent = r1.fm_child and t.id = r2.fm_child) order by fm_priority, id";
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

$query = "select t.* from fm_relation r, v_task_all t where r.fm_parent = ".$backlogid." and r.fm_child = t.id order by t.fm_priority, t.id";
$backlog = $CORE->executeQuery($conn, $query);
$VIEW->assign("backlog", $backlog);
$VIEW->assign("backlogid", $backlogid);

$CORE->closeConnection($conn);
?>
