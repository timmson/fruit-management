<?php

namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/mysqli_wrapper.php");

class SubscriberDAOTest extends TestCase
{

    /**
     * @var mysqli_wrapper
     */
    private mysqli_wrapper $mysqli;

    /**
     * @var SubscriberDAO
     */
    private SubscriberDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new mysqli_wrapper();
        $this->dao = new SubscriberDAO($this->mysqli);
    }

    public function testGetSubscribersByTaskId()
    {
        $id = 1;
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from fm_subscribe where fm_task = 1", $arrange);
        $result = $this->dao->getSubscribersByTaskId($id);

        $this->assertEquals($arrange, $result);
    }

    public function testSubscribe()
    {
        $id = 1;
        $name = "fruit";
        $arrange = [];

        $this->mysqli->addQueryAndResult("insert into fm_subscribe values(null, 1, 'fruit')", $arrange);
        $this->dao->subscribe($id, $name);

        $this->assertTrue(true);
    }

    public function testUnsubscribe()
    {
        $id = 1;
        $name = "fruit";
        $arrange = [];

        $this->mysqli->addQueryAndResult("delete from fm_subscribe where fm_user ='fruit' and fm_task = 1", $arrange);
        $this->dao->unsubscribe($id, $name);

        $this->assertTrue(true);
    }

    
}
