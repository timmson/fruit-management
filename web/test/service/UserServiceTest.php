<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimeSheetDAO;
use ru\timmson\FruitMamangement\dao\UserDAO;

class UserServiceTest extends TestCase
{

    private UserService $service;
    /**
     * @var TimeSheetDAO
     */
    private $timesheetDAO;
    /**
     * @var TaskDAO
     */
    private $taskDAO;
    /**
     * @var UserDAO
     */
    private $userDAO;

    protected function setUp(): void
    {
        parent::setUp();
        $this->timesheetDAO = $this->createMock(TimesheetDAO::class);
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->userDAO = $this->createMock(UserDAO::class);
        $this->service = new UserService($this->timesheetDAO, $this->taskDAO, $this->userDAO);
    }

    public function testSync()
    {
        $request = [
            "week" => 1
        ];
        $user = "user";

        $result = $this->service->sync($request, $user);

        $this->assertCount(3, $result);

    }

    public function testAsync()
    {
        $arrange = ["fm_name" => "", "fm_descr" => ""];
        $request = [
            "user" => "user"
        ];
        $user = "user";

        $this->userDAO->method("getUserByName")->with($user)->willReturn($arrange);
        $result = $this->service->async($request, $user);

        $this->assertCount(1, $result);
    }

    public function testLoginWithRightCredentials()
    {
        $login = "user";
        $password = "right_password";
        $arrange = ["fm_name" => $login, "fm_descr" => "", "fm_password_enc" => md5($password)];

        $this->userDAO->method("getUserByNameAndPassword")->with($login, md5($password))->willReturn($arrange);
        $result = $this->service->login($login, $password);

        $this->assertEquals([0, "SUCCESS"], $result);
    }

    public function testLoginAsRoot()
    {
        $login = "root";
        $password = "root";

        $result = $this->service->login($login, $password);

        $this->assertEquals([0, "SUCCESS"], $result);
    }


    public function testLoginWithBadCredentials()
    {

        $login = "user";
        $password = "wrong_password";

        $result = $this->service->login($login, $password);

        $this->assertEquals([-1, "WRONG_CREDENTIALS"], $result);
    }

/*$root_name = "root";
$root_pass = "5f4dcc3b5aa765d61d8327deb882cf99";

$ret = "";
if (($root_name == $login) && ($root_pass == md5($pass))) {
$ret = $this->root_role;
$_SESSION["user"]["fio"] = $login;
$_SESSION["user"]["mail"] = $_SERVER['SERVER_ADMIN'];
$_SESSION["user"]["samaccountname"] = $login;
} else {

    $result = $userDAO ->getUserByNameAndPassword($login, md5($pass));

    if ($result != null) {
        $ret = $this->root_role;
        $_SESSION["user"]["fio"] = $result["fm_descr"];
        $_SESSION["user"]["samaccountname"] = $login;
        //$_SESSION["user"]["mail"] = $result["fm_descr"];
    }
}*/
}
