<?php

use ru\timmson\FruitManagement\Core;
use ru\timmson\FruitManagement\dao\Connection;
use ru\timmson\FruitManagement\dao\GenericDAO;
use ru\timmson\FruitManagement\dao\GenericDAOImpl;
use ru\timmson\FruitManagement\dao\SubscriberDAO;
use ru\timmson\FruitManagement\dao\SubscriberDAOImpl;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\dao\TaskDAOImpl;
use ru\timmson\FruitManagement\dao\TimesheetDAO;
use ru\timmson\FruitManagement\dao\TimesheetDAOImpl;
use ru\timmson\FruitManagement\dao\UserDAO;
use ru\timmson\FruitManagement\dao\UserDAOImpl;
use ru\timmson\FruitManagement\http\HTTPSession;
use ru\timmson\FruitManagement\http\Session;

require_once(__DIR__."/vendor/autoload.php");

$siteconfig = './config/site.ini';

$CORE = new Core(parse_ini_file($siteconfig, true));
$VIEW = $CORE->smarty;
set_error_handler(array($CORE, 'customErrorHandler'));

$conn = $CORE->getConnection();

$containerBuilder = new DI\ContainerBuilder();
$containerBuilder->addDefinitions([
    Connection::class => $conn,
    GenericDAO::class => new GenericDAOImpl($conn),
    SubscriberDAO::class => new SubscriberDAOImpl($conn),
    TaskDAO::class => new TaskDAOImpl($conn),
    TimesheetDAO::class => new TimesheetDAOImpl($conn),
    UserDAO::class => new UserDAOImpl($conn),
    Session::class => new HTTPSession($_SESSION)
]);
$container = $containerBuilder->build();


/* * * Login block ** */
$is_out = ($_GET["login"] == "logout");

if (($_SESSION["login"] == "") || ($is_out)) {
    $mess = "";

    if ((isset($_REQUEST["login"])) && (!$is_out)) {
        $login = $CORE->auth($_REQUEST["login"], $_REQUEST["pass"], $container->get(UserDAO::class));
        if ($login == "") {
            $mess = "fail";
        }
    } else {
        $login = "";
        $mess = "";
        //header("Location: .");
    }

    if ($login == "") {
        $VIEW->assign("mess", $mess);
        session_unset();
        $VIEW->display($CORE->login_tpl);
        exit;
    }

    $_SESSION["login"] = $login;
}
/* * * End of login block ** */

/* * * Session params block ** */
if (isset($_REQUEST['zone'])) {
    $_SESSION['zone'] = $_REQUEST['zone'];
}

if (isset($_REQUEST['dep'])) {
    $_SESSION['dep'] = $_REQUEST['dep'];
}
/* * * End of session params block ** */

$currentdep = $CORE->getcurrentdep($_SESSION['zone'], $_SESSION['dep']);
$_SESSION['dep'] = $currentdep['name'];

/* * * Temprary debug ** */

try {
    if ($container->has($currentdep['service'])) {

        $service = $container->get($currentdep['service']);

        $user = strlen($_REQUEST['user'])>0?$_REQUEST['user']:$_SESSION['user']['samaccountname'];
        $view = [];


        if ($_REQUEST['mode'] == 'async') {

            $view = $service->async($_REQUEST, $user);

        } else {

            $view = $service->sync($_REQUEST, $user);

        }


        foreach ($view as $key => $value) {
            $VIEW->assign($key, $value);
        }

        $CORE->closeConnection($conn);
    } else if (!file_exists($CORE->inc_admin_dir . $currentdep['incl'])) {
        $CORE->errorHandler(E_ERROR, 'File not found -' . $CORE->inc_admin_dir . $currentdep['incl'], 'admin.php', 57);
    } else {
    	$loadTime = microtime(true);
        include_once($CORE->inc_admin_dir . $currentdep['incl']);
        $loadTime = round(microtime(true)-$loadTime, 2);
        $VIEW->assign('loadTime', $loadTime);
    }
    $VIEW->assign('page', $currentdep['tpl']);
    if (!file_exists($CORE->tpl_admin_dir . $currentdep['tpl'])) {
        $CORE->errorHandler(E_ERROR, 'File not found -' . $CORE->tpl_admin_dir . $currentdep['tpl'], 'admin.php', 60);
        $currentdep['tpl'] = $CORE->default_tpl;
    }
} catch (Exception $e) {
    $CORE->errorHandler(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
}

/* * * End of Temprary debug ** */

$CORE->applypolicy($_SESSION['login'], $_SESSION['zone']);
$VIEW->assign('dep', $_SESSION['dep']);
$VIEW->assign('zone', $_SESSION['zone']);
if ($_REQUEST['mode'] == 'async') {
    if ($_REQUEST['oper'] == 'xls') {
        header("Content-Type:  application/vnd.ms-excel; charset=".$CORE->configuration['global']['encodingHTML']);
        header("Content-Disposition: attachment; filename=" . $_SESSION['zone'] . "_" . $_SESSION['dep'] . "_" . time() . ".xls");
		$VIEW->display($currentdep['tpl']);
    } else if ($_REQUEST['oper'] == 'doc') {
		header("Content-Type:  text/html; charset=".$CORE->configuration['global']['encodingHTML']);
		//header("Content-Type:  application/vnd.ms-word; charset=".$CORE->configuration['global']['encodingHTML']);
		$fileName = microtime();
		if ($_SESSION['dep']=='export') {
			$userName = explode(" ", $_SESSION['user']['fio']);
			$fileName = date('Y')."w".($_REQUEST['week']+1)."_RDG_".$userName[0];
		} else if ($_SESSION['dep']=='plan') {
			$fileName = "Release";
		}
		header("Content-Disposition: attachment; filename=".$fileName.".doc");
		$VIEW->display($currentdep['tpl']);
    } else if ($_REQUEST['oper'] == 'gif') {
		header("Content-type:  image/gif");
	} else if ($_REQUEST['oper'] == 'json') {
		header("Content-type:  text/json");
    } else {
		header("Content-Type:  text/html; charset=".$CORE->configuration['global']['encodingHTML']);
		$VIEW->display($currentdep['tpl']);
    }
} else {
    //$CORE->log_access();
    $VIEW->display($CORE->admin_tpl);
}
//print_r($CORE->debugs);
