<?php


namespace ru\timmson\FruitMamangement\dao;

/**
 * Interface GenericDAO
 * @package ru\timmson\FruitMamangement\dao
 */
interface GenericDAO
{
    /**
     * @param string $user
     * @return array
     */
    public function getActivity(string $user): array;

}