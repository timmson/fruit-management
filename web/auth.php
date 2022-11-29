<?php

use ru\timmson\FruitManagement\Core;
use ru\timmson\FruitManagement\dao\Connection;
use ru\timmson\FruitManagement\dao\UserDAO;
use ru\timmson\FruitManagement\dao\UserDAOImpl;

require_once(__DIR__ . "/vendor/autoload.php");

/**
 * @param $login
 * @param $pass
 * @param $userDAO
 * @return string
 */
function auth($login, $pass, $userDAO): string
{
    $ret = "";
    $result = $userDAO->getUserByNameAndPassword($login, md5($pass));

    if ($result != null) {
        $ret = "developer";
        $_SESSION["user"]["fio"] = $result["fm_descr"];
        $_SESSION["user"]["samaccountname"] = $login;
        //$_SESSION["user"]["mail"] = $result["fm_descr"];
    }

    return $ret;
}

session_start();

if (isset($_REQUEST["logout"])) {
    session_unset();
    header("Location: ..");
    exit();
}

if (!isset($_SESSION["user"])) {

    if (isset($_REQUEST["login"])) {

        $siteconfig = './config/site.ini';

        $CORE = new Core(parse_ini_file($siteconfig, true));

        $conn = $CORE->getConnection();

        $containerBuilder = new DI\ContainerBuilder();
        $containerBuilder->addDefinitions([
            Connection::class => $conn,
            UserDAO::class => new UserDAOImpl($conn)
        ]);

        $container = null;

        try {
            $container = $containerBuilder->build();
        } catch (Exception $e) {
            $CORE->errorHandler(E_ERROR, $e->getMessage(), $e->getFile(), $e->getLine());
        }

        $login = auth($_REQUEST["login"], $_REQUEST["pass"], $container->get(UserDAO::class));

        if ($login == "") {
            $message = "fail";
            header("HTTP/1.1 401 Unauthorized");
            echo json_encode(array("error" => "User is unauthorized", "message" => $message));
            session_unset();
        }

        $_SESSION["login"] = $login;

    } else {
        header("HTTP/1.1 401 Unauthorized");
        echo json_encode(array("error" => "User is unauthorized"));
        session_unset();
    }

    exit();
}

echo json_encode($_SESSION["user"]);
