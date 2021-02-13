<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;
use ru\timmson\FruitMamangement\dao\TaskDAO;
use ru\timmson\FruitMamangement\HTTPSession;

class AgileServiceTest extends TestCase
{

    /**
     * @var AgileService
     */
    private AgileService $service;

    /**
     * @var TaskDAO
     */
    private TaskDAO $taskDAO;
    /**
     * @var HTTPSession
     */
    private HTTPSession $session;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskDAO = $this->createMock(TaskDAO::class);
        $this->session = new HTTPSession([]);
        $this->service = new AgileService($this->taskDAO, $this->session);
    }

    public function testSync()
    {
        $expected = [
            'release' => [['id' => 1]],
            'relid' => 1,
            'structtasks' => [],
            'backlog' => [],
            'backlogid' => 1
        ];

        $request = [];

        $this->taskDAO->method('findAllInProgress')->willReturn($expected['release']);
        $result = $this->service->sync($request, "user");

        $this->assertEquals($expected, $result);
    }

    public function testAsync()
    {
        $expected = [
            'release' => [['id' => 1]],
            'relid' => 1,
            'structtasks' => [],
            'backlog' => [],
            'backlogid' => 1
        ];

        $request = [];

        $this->taskDAO->method('findAllInProgress')->willReturn($expected['release']);
        $result = $this->service->async($request, "user");

        $this->assertEquals($expected, $result);
    }

}
