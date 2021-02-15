<?php


namespace ru\timmson\FruitManagement\dao;


use Exception;

interface ProjectDAO
{
    /**
     * @return array
     * @throws Exception
     */
    public function getProjectsWithTaskCountAndSpentHours(): array;
}