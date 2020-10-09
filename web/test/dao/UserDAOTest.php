<?php

namespace ru\timmson\FruitMamangement\dao;

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . "/mysqli_wrapper.php");

class UserDAOTest extends TestCase
{
    public function testGetUserByName()
    {
        $name = "fruit";
        $mysqli = new mysqli_wrapper();
        $dao = new UserDAOImpl($mysqli);
        $password = "p1ssword";
        $arrange = [["fm_password_enc" => "p1ssword"]];

        $mysqli->addQueryAndResult("select * from fm_user where fm_name = '$name'", $arrange);
        $result = $dao ->getUserByName($name);

        $this->assertEquals($password, $result["fm_password_enc"]);
    }

}
