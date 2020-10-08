<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimesheetDAO;

class HomeServiceTest extends TestCase
{

    private HomeService $service;

    private TimesheetDAO $timesheetDAO;

    private TaskDAO $taskDAO;

    protected function setUp(): void
    {
        parent::setUp();

        $this->timesheetDAO = $this->createMock(TimesheetDAO::class);
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->service = new HomeService($this->timesheetDAO, $this->taskDAO);
    }

    public function testSync()
    {
        $request = [
            "plandate" => 1,
            "week" => 1
        ];
        $user = "user";

        $result = $this->service->sync($request, $user);

        $this->assertCount(5, $result);
    }


}
