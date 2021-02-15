<?php


namespace ru\timmson\FruitManagement\service;

use Exception;

/**
 * Interface Service with synchronous and asynchronous methods
 * @package ru\timmson\FruitManagement\service
 */
interface Service
{

    /**
     * @param array $request
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function sync(array $request, string $user): array;

    /**
     * @param array $request
     * @param string $user
     * @return array
     * @throws Exception
     */
    public function async(array $request, string $user): array;
}