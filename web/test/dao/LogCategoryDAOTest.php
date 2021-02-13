<?php

namespace ru\timmson\FruitManagement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/MockConnection.php");

class LogCategoryDAOTest extends TestCase
{
    /**
     * @var MockConnection
     */
    private MockConnection $mysqli;

    /**
     * @var LogCategoryDAO
     */
    private LogCategoryDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new MockConnection();
        $this->dao = new LogCategoryDAO($this->mysqli);
    }

    public function testGetAllOrderById()
    {
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from fm_cat_log order by id", $arrange);
        $result = $this->dao->getAllOrderById();

        $this->assertEquals($arrange, $result);
    }

}
