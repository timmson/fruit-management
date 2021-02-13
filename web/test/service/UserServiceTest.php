<?php

namespace ru\timmson\FruitManagement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\dao\TimeSheetDAO;
use ru\timmson\FruitManagement\dao\UserDAO;

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

        $this->assertEquals([0, "SUCCESS", $arrange], $result);
    }

    public function testLoginAsRoot()
    {
        $login = "root";
        $password = "root";
        $arrange = ["fm_name" => $login, "fm_descr" => "", "fm_password_enc" => md5($password)];

        $result = $this->service->login($login, $password);

        $this->assertEquals([0, "SUCCESS", $arrange], $result);
    }


    public function testLoginWithBadCredentials()
    {

        $login = "user";
        $password = "wrong_password";

        $result = $this->service->login($login, $password);

        $this->assertEquals([-1, "WRONG_CREDENTIALS"], $result);
    }

}
