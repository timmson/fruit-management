<?php

namespace ru\timmson\FruitMamangement\dao;

require_once(__DIR__ . "/mysqli_wrapper.php");

use PHPUnit\Framework\TestCase;

/**
 * Class GenericDAOTest
 * @package ru\timmson\FruitMamangement\dao
 */
class GenericDAOTest extends TestCase
{

    /**
     * @var mysqli_wrapper
     */
    private mysqli_wrapper $mysqli;

    /**
     * @var GenericDAO
     */
    private GenericDAO $dao;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mysqli = new mysqli_wrapper();
        $this->dao = new GenericDAOIml($this->mysqli);
    }

    public function testGetActivity()
    {
        $user = "user";
        $arrange = [["name" => "0", "work" => "yes"]];

        $this->mysqli->addQueryAndResult("select * from (select l.*, datediff(curdate(), fm_date) as fm_days_ago, t.fm_name, t.fm_descr from fm_work_log l, v_task_all t where t.id = l.fm_task and l.fm_user <> 'user' order by l.fm_date desc, l.id desc)   a where a.fm_days_ago > -1 and a.fm_days_ago < 5 limit 15", $arrange);
        $result = $this->dao->getActivity($user);

        $this->assertEquals($arrange, $result);

    }


}
