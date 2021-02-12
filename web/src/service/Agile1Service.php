<?php


namespace ru\timmson\FruitMamangement\service;

/**
 * Class Agile1Service
 * @package ru\timmson\FruitMamangement\service
 */
class Agile1Service implements Service
{

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function sync(array $request, string $user): array
    {
        return [];
    }

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function async(array $request, string $user): array
    {
        return [];
    }
}