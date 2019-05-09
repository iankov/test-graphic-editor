<?php

namespace App\Models\Shape\Option;


class Border
{
    protected $color, $width;

    /**
     * Border constructor.
     *
     * @param Color $color
     * @param int $width
     *
     * @throws \Exception
     */
    public function __construct(Color $color, int $width)
    {
        if($width <= 0){
            throw new \Exception('Border width must be greater then zero');
        }

        $this->color = $color;
        $this->width = $width;
    }

    public function color()
    {
        return $this->color;
    }

    public function width()
    {
        return $this->width;
    }
}