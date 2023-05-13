<?php

namespace ru\timmson\FruitManagement;

use ru\timmson\FruitManagement\dao\MySQLConnection;
use Smarty;

class Core
{

    public $admin_tpl = "index.tpl";
    public $default_tpl = "homeeditor.tpl";
    public $smarty_compile_dir = "./smarty/templates_c/";
    public $smarty_config_dir = "./smarty/config/";
    public $smarty_cache_dir = "./smarty/cache/";
    public $img_admin_dir = "./img/";
    public $inc_admin_dir = "./include/";
    public $js_dir = "./js";
    public $stylesheet_dir = "./css/";
    public $tpl_admin_dir = "./templates/";
    public $configuration = null;
    public $smarty = null;
    public $roles = null;
    private $root_role = "developer";
    public $debugs = array();
    private $error = 0;
    private $connection = null;

    public function __construct($conf)
    {
        if ($conf != null) {
            $this->configuration = $conf;
            $this->init();
            $this->initSmarty();
            $this->initSections();
        }
    }

    private function init()
    {
        setlocale(LC_ALL, "");
        ini_set("memory_limit", $this->configuration["memory_limit"]);
        date_default_timezone_set($this->configuration["timezone"]);
        $this->configuration["major"] = (date("y") - 7);
        $this->configuration["minor"] = "." . date("m");
        $this->configuration["copyright"] = $this->configuration["copyright"] . "-" . date("Y");
    }

    public function getConnection(): ?MySQLConnection
    {
        if ($this->connection == null) {
            $timeout = microtime();
            $this->connection = new MySQLConnection($_ENV["MYSQL_HOST"], $_ENV["MYSQL_PORT"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], $_ENV["MYSQL_DATABASE"]);
            $this->debugTimeout("MY CONNECT", $timeout, 5);
        }
        return $this->connection;
    }

    public function executeQuery($conn, $query, $debug = 0)
    {
        $timeout = microtime();
        $data = $conn->query($query);
        $this->debugTimeout("EXECUTE", $timeout, 5);
        $this->debugQuery($query, $data, $debug);
        return $data;
    }

    public function closeConnection($conn): void
    {
        $conn->close();
    }

    private function debugTimeout($descr, $timeout, $limit): void
    {
        $tmp = explode(" ", microtime());
        $end = $tmp[0] + $tmp[1];
        $tmp = explode(" ", $timeout);
        $start = $tmp[0] + $tmp[1];
        $timeout = round($end - $start, 2);
        if ($timeout < $limit) {
            $this->debugs[] = $descr . " TIMEOUT: " . $timeout . "s";
        } else {
            $this->debugs[] = "<span style=\"color:red;\">" . $descr . " TIMEOUT: " . $timeout . "s</span>";
        }
    }

    private function debugQuery($query, $data, $debug): void
    {
        if (count($data) == 0) {
            $data[0] = "No rows found";
        }
        $trace = "QUERY:<b>" . $query . "</b><br/>";
        $trace .= "FIRST ROW:";
        $trace .= "<pre>";
        $trace .= print_r($debug > 1 ? $data : $data[0], true);
        $trace .= "</pre>";
        $this->debugs[] = $trace;
    }

    private function initSmarty(): void
    {
        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($this->tpl_admin_dir);
        $this->smarty->setConfigDir($this->smarty_config_dir);
        $this->smarty->setCompileDir($this->smarty_compile_dir);
        $this->smarty->setCacheDir($this->smarty_cache_dir);
        $this->smarty->assign("const", $this->configuration);
        $this->smarty->assign("factory", $this);
    }

    private function initSections(): void
    {
        for ($j = 0; $j < count($this->configuration["sections"]); $j++) {
            $section = $this->configuration["sections"][$j];
            $this->configuration["sections"][$j] = array(
                "name" => $section,
                "description" => $this->configuration[$section]["description"],
                "new_front" => $this->configuration[$section]["new_front"],
                "incl" => $section . "editor.php",
                "service" => "\\ru\\timmson\\FruitManagement\\service\\" . ucfirst($section) . "Service",
                "icon" => "admin_" . $section . ".gif",
                "tpl" => $section . "editor.tpl"
            );
        }
        $this->root_role = $this->configuration["roles"]["root"];
        $this->guest_role = $this->configuration["roles"]["guest"];
        $roles = $this->configuration["roles"]["role"];
        for ($i = 0; $i < count($roles); $i++) {
            $this->roles[$roles[$i]]["name"] = $roles[$i];
            $this->roles[$roles[$i]]["login"] = $this->configuration[$roles[$i]]["login"];
            $this->roles[$roles[$i]]["description"] = $this->configuration[$roles[$i]]["description"];
            $this->roles[$roles[$i]]["email"] = "XXXXXXX";
        }
    }


    public function customErrorHandler($errno, $errstr, $errfile, $errline): bool
    {
        global $CORE;
        $CORE->errorHandler($errno, $errstr, $errfile, $errline);
        return true;
    }

    public function errorHandler($errno, $errstr, $errfile, $errline): void
    {
        if ($errno < $this->configuration["debug"]) {
            echo "#" . $errno . ":" . $errstr . "<br/>[" . $errfile . "@" . $errline . "] E" . $this->error . "<br/>";
        }
        switch ($errno) {
            case E_ERROR:
            case E_PARSE:
            case E_WARNING:
                $this->error++;
                $this->smarty->assign("mess", $errstr . "<br/>[" . $errfile . "@" . $errline . "] E" . $this->error);
                $this->debugs[] = "#" . $errno . ":" . $errstr . "<br/>[" . $errfile . "@" . $errline . "] E" . $this->error . "<br/>";
                break;

            case E_NOTICE:
                break;

            default:
                if ($errno < 128) {
                    echo "Unknown error type: [$errno] $errstr<br />\n";
                }
                break;
        }
    }

    function search($login)
    {
        return [];
    }

    function getSections()
    {
        return $this->configuration["sections"];
    }

    function getCurrentSection($section)
    {
        $sections = $this->getSections();

        for ($i = 0; $i < count($sections); $i++) {
            if ($sections[$i]["name"] == $section) {
                return $sections[$i];
            }
        }

        return $sections[0];
    }

}
