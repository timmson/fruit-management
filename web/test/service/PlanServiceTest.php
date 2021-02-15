<?php

namespace ru\timmson\FruitManagement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\dao\TaskDAO;
use ru\timmson\FruitManagement\http\HTTPSession;
use ru\timmson\FruitManagement\http\Session;


class PlanServiceTest extends TestCase
{
    private PlanService $planService;

    private TaskDAO $taskDAO;

    private Session $session;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->session = new HTTPSession([]);
        $this->planService = new PlanService($this->taskDAO, $this->session);
    }


    public function testSync()
    {
        $request = [
            "release" => 1,
            "plandate" => ""
        ];
        $user = "user";

        $expected = [
            'release' => [],
            'relid' => 1,
            'plantasks' => [],
            'monthcal' => [],
            'structtasks' => []
        ];

        $result = $this->planService->sync($request, $user);

        $this->assertEquals($expected["release"], $result["release"]);
        $this->assertEquals($expected["relid"], $result["relid"],);
        $this->assertEquals($expected["plantasks"], $result["plantasks"]);
        $this->assertArrayHasKey("monthcal", $result);
        $this->assertEquals($expected["structtasks"], $result["structtasks"]);
    }

}
