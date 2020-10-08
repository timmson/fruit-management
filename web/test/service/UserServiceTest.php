<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimeSheetDAO;

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

    protected function setUp(): void
    {
        parent::setUp();
        $this->timesheetDAO = $this->createMock(TimesheetDAO::class);
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->service = new UserService($this->timesheetDAO, $this->taskDAO);
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
        $request = [];
        $user = "user";

        $result = $this->service->async($request, $user);

        $this->assertCount(1, $result);
    }


}
