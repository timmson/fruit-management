<?php

namespace ru\timmson\FruitManagement\http;

interface Session
{

    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param string $name
     * @param $value
     * @return mixed
     */
    public function set(string $name, $value);

    /**
     * @param string $name
     * @return bool
     */
    public function contains(string $name): bool;
}