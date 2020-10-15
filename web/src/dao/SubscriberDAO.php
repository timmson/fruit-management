<?php

namespace ru\timmson\FruitMamangement\dao;


use Exception;

/**
 * Class SubscriberDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface SubscriberDAO
{
    /**
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getSubscribersByTaskId(int $id);

    /**
     * @param int $id
     * @param string $name
     * @throws Exception
     */
    public function subscribe(int $id, string $name): void;

    /**
     * @param int $id
     * @param string $name
     * @throws Exception
     */
    public function unsubscribe(int $id, string $name): void;
}