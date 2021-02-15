<?php

namespace ru\timmson\FruitManagement\service;

use Exception;
use PHPUnit\Framework\TestCase;
use ru\timmson\FruitManagement\dao\ProjectDAO;
use ru\timmson\FruitManagement\dao\WorkLogDAO;
use ru\timmson\FruitManagement\http\Image;

class ProjectServiceTest extends TestCase
{

    /**
     * @var ProjectService
     */
    private ProjectService $projectService;

    /**
     * @var ProjectDAO
     */
    private ProjectDAO $projectDAO;

    /**
     * @var WorkLogDAO
     */
    private WorkLogDAO $workLogDAO;

    /**
     * @var Image
     */
    private Image $image;

    protected function setUp(): void
    {
        parent::setUp();
        $this->projectDAO = $this->createMock(ProjectDAO::class);
        $this->workLogDAO = $this->createMock(WorkLogDAO::class);
        $this->image = $this->createMock(Image::class);
        $this->projectService = new ProjectService($this->projectDAO, $this->workLogDAO, $this->image);
    }

    /**
     * @throws Exception
     */
    public function testSync()
    {
        $request = [];
        $user = "user";
        $expected = [
            "data" => []
        ];

        $result = $this->projectService->sync($request, $user);

        $this->assertEquals($expected, $result);
    }

    /**
     * @throws Exception
     */
    public function testAsyncGif()
    {
        $request = [
            "mode" => "async",
            "oper" => "gif",
            "project" => 1
        ];
        $user = "user";
        $expected = [];

        $workedLog = [["spent_hours" => 1, "week" => 1]];
        $this->workLogDAO->method("getWorkedLog")->willReturn($workedLog);
        $this->image->method("colorAllocate")->willReturn(0);

        $result = $this->projectService->sync($request, $user);

        $this->assertEquals($expected, $result);
    }

}
