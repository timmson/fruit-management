<?php
$conn = $CORE->getConnection();
$taskDAO = $container->get(\ru\timmson\FruitMamangement\dao\TaskDAO::class);

$backlogId = 1;

$release = $taskDAO->findAllInProgress(["fm_project" => "REL"], ["id" => "desc"]);
if (strlen($_REQUEST['release']) > 0) {
    $releaseId = $_REQUEST['release'];
} else if (strlen($_SESSION['release']) > 0) {
    $releaseId = $_SESSION['release'];
} else {
    $releaseId = $release[0]['id'];
}

$_SESSION['release'] = $releaseId;
$VIEW->assign("release", $release);
$VIEW->assign("relid", $releaseId);

if (isset($_REQUEST['oper'])) {
    $taskId = $_REQUEST['task'];
    $toId = $_REQUEST['toid'];
    $query = 'select r1.fm_parent as id from fm_relation r1, fm_relation r2 where r1.fm_child = ' . $taskId . ' and r2.fm_parent = ' . $releaseId . ' and r1.fm_parent = r2.fm_child';
    $fromId = $CORE->executeQuery($conn, $query);
    $fromId = (strlen($fromId[0]['id']) > 0) ? $fromId[0]['id'] : $backlogId;
    if ($_REQUEST['oper'] == 'plan') {
        $taskDAO->changeParent($taskId, $fromId, $toId);
    } else if ($_REQUEST['oper'] == 'state') {
        $taskDAO->updateStatus($taskId, $toId);
    }
}

$query = " (select t.*, r1.fm_parent as fm_parent from fm_relation r1, v_task_all t ";
$query .= " where r1.fm_parent = " . $releaseId . " and t.id = r1.fm_child) ";
$query .= " union ";
$query .= " (select t.*, r2.fm_parent as fm_parent from fm_relation r1, fm_relation r2, v_task_all t ";
$query .= " where r1.fm_parent = " . $releaseId . " and r2.fm_parent = r1.fm_child and t.id = r2.fm_child) order by fm_priority, id";
$temp = $CORE->executeQuery($conn, $query);
$structtasks = array();


for ($i = 0; $i < count($temp); $i++) {
    if ($temp[$i]['fm_parent'] == $releaseId) {
        $structtasks[] = $temp[$i];
    }
}

for ($i = 0; $i < count($temp); $i++) {
    if ($temp[$i]['fm_parent'] != $releaseId) {
        for ($j = 0; $j < count($structtasks); $j++) {
            if ($temp[$i]['fm_parent'] == $structtasks[$j]['id']) {
                $structtasks[$j]['child'][] = $temp[$i];
            }
        }
    }
}
$VIEW->assign("structtasks", $structtasks);

$backlog = $taskDAO->findAllByParentId($backlogId);
$VIEW->assign("backlog", $backlog);
$VIEW->assign("backlogid", $backlogId);

$CORE->closeConnection($conn);

