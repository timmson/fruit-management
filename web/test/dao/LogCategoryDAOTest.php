<?php

namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/mysqli_wrapper.php");

class LogCategoryDAOTest extends TestCase
{
    /**
     * @var mysqli_wrapper
     */
    private mysqli_wrapper $mysqli;

    /**
     * @var LogCategoryDAO
     */
    private LogCategoryDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new mysqli_wrapper();
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
