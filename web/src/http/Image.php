<?php


namespace ru\timmson\FruitManagement\http;

/**
 * Interface Image
 * @package ru\timmson\FruitManagement\service
 */
interface Image
{

    /**
     * @param int $width
     * @param int $height
     * @return mixed
     */
    public function create(int $width, int $height);

    /**
     * @param mixed $image
     * @param int $red
     * @param int $green
     * @param int $blue
     * @return int|false
     */
    public function colorAllocate($image, int $red, int $green, int $blue);

    /**
     * @param mixed $image
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $color
     * @return bool
     */
    public function filledRectangle($image, int $x1, int $y1, int $x2, int $y2, int $color) : bool;

    /**
     * @param mixed $image
     * @param int $cx
     * @param int $cy
     * @param int $width
     * @param int $height
     * @param int $start
     * @param int $end
     * @param int $color
     * @return bool
     */
    public function arc($image, int $cx,  int $cy,  int $width, int $height,  int $start, int $end, int $color):bool;

    /**
     * @param mixed $image
     * @param int $font
     * @param int $x
     * @param int $y
     * @param string $string
     * @param int $color
     * @return bool
     */
    function string($image, int $font, int $x, int $y, string $string, int $color): bool;

    /**
     * @param mixed $image
     */
    public function send($image): void;

}