<?php

namespace ru\timmson\FruitManagement\service;

use Exception;
use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\dao\WorkLogDAO;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\dao\TimesheetDAO;

class HomeServiceTest extends TestCase
{

    private HomeService $service;

    private TaskDAO $taskDAO;

    private TimesheetDAO $timesheetDAO;

    private WorkLogDAO $workLogDAO;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workLogDAO = $this->createMock(WorkLogDAO::class);
        $this->timesheetDAO = $this->createMock(TimesheetDAO::class);
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->service = new HomeService(
            $this->taskDAO,
            $this->timesheetDAO,
            $this->workLogDAO
        );
    }

    /**
     * @throws Exception
     */
    public function testSync()
    {
        $request = [
            "plandate" => 1,
            "week" => 1
        ];
        $user = "user";

        $tasks = [["fm_plan_hour" => 10, "fm_all_hour" => 0]];

        $this->taskDAO->method("findAllInProgress")->willReturn($tasks);
        $result = $this->service->sync($request, $user);

        $this->assertCount(5, $result);
    }

    /**
     * @throws Exception
     */
    public function testAsync()
    {
        $request = [];
        $user = "user";

        $result = $this->service->async($request, $user);

        $this->assertCount(1, $result);
    }


}
