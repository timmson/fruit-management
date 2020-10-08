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
        $this->timesheetDAO = new class implements TimesheetDAO {
            function getCurrentWeekTimeSheetByUser($user): array
            {
                return [];
            }
        };
        $this->taskDAO = new class implements TaskDAO {

            function getColumns(): array
            {
                // TODO: Implement getColumns() method.
            }

            public function getTaskById(int $id)
            {
                // TODO: Implement getTaskById() method.
            }

            public function getTaskByName(string $name)
            {
                // TODO: Implement getTaskByName() method.
            }

            public function getAllTasks(array $filter = [], array $order = []): array
            {
                // TODO: Implement getAllTasks() method.
            }

            public function getTasksInProgress(array $filter = [], array $order = []): array
            {
                return [["fm_plan_hour" => 20, "fm_all_hour" => 10 ]];
            }

            public function getSubscribedTaskByUser(string $user): array
            {
                return [[]];
            }
        };

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
