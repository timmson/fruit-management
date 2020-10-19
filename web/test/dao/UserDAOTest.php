<?php

namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/MockConnection.php");

class UserDAOTest extends TestCase
{


    private Connection $connection;
    private UserDAO $dao;

    protected function setUp():void
    {
        $this->connection = new MockConnection();
        $this->dao = new UserDAOImpl($this->connection);
    }


    public function testGetUserByName()
    {
        $name = "fruit";
        $password = "p1ssword";
        $arrange = [["fm_password_enc" => "p1ssword"]];

        $this->connection->addQueryAndResult("select * from fm_user where fm_name = '$name'", $arrange);
        $result = $this->dao ->getUserByName($name);

        $this->assertEquals($password, $result["fm_password_enc"]);
    }

    public function testGetUserByNameAndPassword() {
        $name = "fruit";
        $password = "p1ssword";
        $arrange = [["fm_password_enc" => $password]];

        $this->connection->addQueryAndResult("select * from fm_user where fm_name = '$name' and fm_password_enc = '$password'", $arrange);
        $result = $this->dao ->getUserByNameAndPassword($name, $password);

        $this->assertNotNull($result);
    }

}
