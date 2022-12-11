<?php

use ru\timmson\FruitManagement\Core;
use ru\timmson\FruitManagement\dao\Connection;
use ru\timmson\FruitManagement\dao\ProjectDAO;
use ru\timmson\FruitManagement\dao\ProjectDAOImpl;
use ru\timmson\FruitManagement\dao\SubscriberDAO;
use ru\timmson\FruitManagement\dao\SubscriberDAOImpl;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\dao\TaskDAOImpl;
use ru\timmson\FruitManagement\dao\TimesheetDAO;
use ru\timmson\FruitManagement\dao\TimesheetDAOImpl;
use ru\timmson\FruitManagement\dao\UserDAO;
use ru\timmson\FruitManagement\dao\UserDAOImpl;
use ru\timmson\FruitManagement\dao\WorkLogDAO;
use ru\timmson\FruitManagement\dao\WorkLogDAOImpl;
use ru\timmson\FruitManagement\http\HTTPImage;
use ru\timmson\FruitManagement\http\HTTPSession;
use ru\timmson\FruitManagement\http\Image;
use ru\timmson\FruitManagement\http\Session;

require_once(__DIR__ . "/vendor/autoload.php");

$siteconfig = './config/site.ini';

$CORE = new Core(parse_ini_file($siteconfig, true));
session_start();

$VIEW = $CORE->smarty;
set_error_handler(array($CORE, 'customErrorHandler'));

$conn = $CORE->getConnection();

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions([
    Connection::class => $conn,
    Image::class => new HTTPImage(),
    ProjectDAO::class => new ProjectDAOImpl($conn),
    Session::class => new HTTPSession($_SESSION),
    SubscriberDAO::class => new SubscriberDAOImpl($conn),
    TaskDAO::class => new TaskDAOImpl($conn),
    TimesheetDAO::class => new TimesheetDAOImpl($conn),
    UserDAO::class => new UserDAOImpl($conn),
    WorkLogDAO::class => new WorkLogDAOImpl($conn)
]);

$container = null;

try {
    $container = $containerBuilder->build();
} catch (Exception $e) {
    $CORE->errorHandler(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
}


/* * * Login block ** */
if (!isset($_SESSION["login"])) {

    header("Location: .");
    exit;
}
/* * * End of login block ** */

/* * * Session params block ** */
if (isset($_REQUEST["section"])) {
    $_SESSION["section"] = $_REQUEST["section"];
}
/* * * End of session params block ** */

$currentSection = $CORE->getCurrentSection($_SESSION["section"]);
$VIEW->assign("currentSection", $currentSection);
$_SESSION["section"] = $currentSection["name"];

/* * * Temprary debug ** */

try {
    if ($container->has($currentSection["service"])) {
        $service = $container->get($currentSection["service"]);
        $user = isset($_REQUEST["user"]) ? $_REQUEST['user'] : $_SESSION["user"]["samaccountname"];
        $view = [];

        if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "async") {
            $view = $service->async($_REQUEST, $user);
        } else {
            $view = $service->sync($_REQUEST, $user);
        }

        if ($currentSection["new_front"]) {
            echo json_encode($view);
        }

        foreach ($view as $key => $value) {
            $VIEW->assign($key, $value);
        }

        $CORE->closeConnection($conn);
    } else if (!file_exists($CORE->inc_admin_dir . $currentSection["incl"])) {
        $CORE->errorHandler(E_ERROR, 'File not found -' . $CORE->inc_admin_dir . $currentSection['incl'], 'admin.php', 57);
    } else {
        $loadTime = microtime(true);
        include_once($CORE->inc_admin_dir . $currentSection["incl"]);
        $loadTime = round(microtime(true) - $loadTime, 2);
        $VIEW->assign("loadTime", $loadTime);
    }
    $VIEW->assign("page", $currentSection["tpl"]);
    if (!file_exists($CORE->tpl_admin_dir . $currentSection["tpl"])) {
        $CORE->errorHandler(E_ERROR, 'File not found -' . $CORE->tpl_admin_dir . $currentSection['tpl'], 'admin.php', 60);
        $currentSection["tpl"] = $CORE->default_tpl;
    }
} catch (Exception $e) {
    $CORE->errorHandler(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
}

/* * * End of Temprary debug ** */

$VIEW->assign("sections", $CORE->getSections());

if (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "async") {
    if ($_REQUEST["oper"] == 'xls') {
        header("Content-Type:  application/vnd.ms-excel; charset=" . $CORE->configuration['global']['encodingHTML']);
        header("Content-Disposition: attachment; filename=" . $_SESSION['zone'] . "_" . $_SESSION['dep'] . "_" . time() . ".xls");
        $VIEW->display($currentSection['tpl']);
    } else if ($_REQUEST["oper"] == 'doc') {
        header("Content-Type:  text/html; charset=" . $CORE->configuration['global']['encodingHTML']);
        //header("Content-Type:  application/vnd.ms-word; charset=".$CORE->configuration['global']['encodingHTML']);
        $fileName = microtime();
        if ($_SESSION['dep'] == 'export') {
            $userName = explode(" ", $_SESSION['user']['fio']);
            $fileName = date('Y') . "w" . ($_REQUEST['week'] + 1) . "_RDG_" . $userName[0];
        } else if ($_SESSION['dep'] == 'plan') {
            $fileName = "Release";
        }
        header("Content-Disposition: attachment; filename=" . $fileName . ".doc");
        $VIEW->display($currentSection['tpl']);
    } else if ($_REQUEST["oper"] == 'gif') {
        header("Content-type:  image/gif");
    } else if ($_REQUEST["oper"] == 'json') {
        header("Content-type:  text/json");
    } else {
        header("Content-Type:  text/html; charset=" . $CORE->configuration['global']['encodingHTML']);

        if (!$currentSection["new_front"]) {
            $VIEW->display($currentSection["tpl"]);
        }
    }
} else {
    if (!$currentSection["new_front"]) {
        $VIEW->display($CORE->admin_tpl);
    }
}
//print_r($CORE->debugs);
