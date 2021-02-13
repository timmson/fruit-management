<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitMamangement\dao\GenericDAO;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\dao\TimesheetDAO;

class HomeServiceTest extends TestCase
{

    private HomeService $service;

    private TimesheetDAO $timesheetDAO;

    private TaskDAO $taskDAO;

    private GenericDAO $genericDAO;

    protected function setUp(): void
    {
        parent::setUp();

        $this->markTestSkipped('Temporary skipped because of https://github.com/timmson/fruit-management/runs/1895098524?check_suite_focus=true');

        $this->genericDAO = $this->createMock(GenericDAO::class);
        $this->timesheetDAO = $this->createMock(TimesheetDAO::class);
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->service = new HomeService(
            $this->genericDAO,
            $this->timesheetDAO,
            $this->taskDAO
        );
    }

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

    public function testAsync()
    {
        $request = [];
        $user = "user";

        $result = $this->service->async($request, $user);

        $this->assertCount(1, $result);
    }


}
