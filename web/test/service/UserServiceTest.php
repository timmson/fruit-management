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


}
