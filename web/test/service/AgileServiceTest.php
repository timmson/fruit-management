<?php

namespace ru\timmson\FruitMamangement\service;

use PHPUnit\Framework\TestCase;

class AgileServiceTest extends TestCase
{

    private Agile1Service $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new Agile1Service();
    }

    public function testSync()
    {
        $request = [];
        $user = "user";
        $result = $this->service->sync($request, $user);

        $this->assertEquals([], $result);
    }

    public function testAsync()
    {
        $request = [];
        $user = "user";

        $result = $this->service->async($request, $user);

        $this->assertEquals([], $result);
    }

}
