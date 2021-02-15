<?php


namespace ru\timmson\FruitManagement\http;


class HTTPImage implements Image
{

    /**
     * @inheritDoc
     */
    public function create(int $width, int $height)
    {
        return imageCreate($width, $height);
    }

    /**
     * @inheritDoc
     */
    public function colorAllocate($image, int $red, int $green, int $blue)
    {
        return imageColorAllocate($image, $red, $green, $blue);
    }

    /**
     * @inheritDoc
     */
    public function filledRectangle($image, int $x1, int $y1, int $x2, int $y2, int $color): bool
    {
        return imagefilledRectangle($image, $x1, $y1, $x2, $y2, $color);
    }

    /**
     * @inheritDoc
     */
    public function arc($image, int $cx, int $cy, int $width, int $height, int $start, int $end, int $color): bool
    {
        return imagearc($image, $cx, $cy, $width, $height, $start, $end, $color);
    }

    /**
     * @inheritDoc
     */
    function string($image, int $font, int $x, int $y, string $string, int $color): bool
    {
        return imagestring($image, $font, $x, $y, $string, $color);
    }

    /**
     * @inheritDoc
     */
    public function send($image): void
    {
        header("Content-type:  image/gif");
        imageGIF($image);
    }
}