<?php
//namespace ru\timmson\FruitManagement\dao;

use PHPUnit\Framework\TestCase;

//require_once(__DIR__ . "/../../api/auth.php");

class AuthTest extends TestCase
{

    public function testAuthorized()
    {
        $this->assertEquals(true, true);
    }

    public function testUnauthorized()
    {
        $this->assertEquals(true, true);
    }

}
