<?
$conn = $CORE->getConnection();

$user = $_SESSION['user']['samaccountname'];

$timesheetDAO = new \ru\timmson\FruitMamangement\dao\TimesheetDAO($conn);
$taskDAO = new \ru\timmson\FruitMamangement\dao\TaskDAO($conn);
$service = new \ru\timmson\FruitMamangement\service\HomeService($timesheetDAO, $taskDAO);

$view = [];

if ($_REQUEST['mode'] == 'async') {

    $view = $service->async($CORE, $conn, $user);

} else {

    $view = $service->sync($_REQUEST, $user);
}

foreach ($view as $key => $value) {
    $VIEW->assign($key, $value);
}

$CORE->closeConnection($conn);

