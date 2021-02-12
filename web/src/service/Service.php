<?php


namespace ru\timmson\FruitMamangement\service;

/**
 * Interface Service with synchronous and asynchronous methods
 * @package ru\timmson\FruitMamangement\service
 */
interface Service
{

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function sync(array $request, string $user): array;

    /**
     * @param array $request
     * @param string $user
     * @return array
     */
    public function async(array $request, string $user): array;
}