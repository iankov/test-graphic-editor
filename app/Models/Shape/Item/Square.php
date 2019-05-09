<?php

namespace App\Models\Shape\Item;

use App\Models\Shape\Option\Border;
use App\Models\Shape\Option\Color;

class Square implements ShapeInterface
{
    protected $border, $color, $image, $sideLength;

    protected $x = 0;
    protected $y = 0;
    protected $width = 0;
    protected $height = 0;

    public function __construct(int $sideLength = 100)
    {
        $this->x = 0;
        $this->y = 0;

        $this->sideLength = $sideLength;
    }

    public function setBorder(Border $border)
    {
        $this->border = $border;

        return $this;
    }

    public function setColor(Color $color)
    {
        $this->color = $color;

        return $this;
    }

    public function setParams(array $params)
    {
        if(isset($params['perimeter'])){
            $this->setPerimeter($params['perimeter']);
        }

        if(isset($params['sideLength'])){
            $this->setSideLength($params['sideLength']);
        }
    }

    public function setSideLength(int $side)
    {
        $this->sideLength = $side;

        return $this;
    }

    public function setPerimeter(int $perimeter)
    {
        $this->sideLength = intval($perimeter / 4);

        return $this;
    }

    public function draw()
    {
        $this->createCanvas();
        $this->fill();
        $this->drawBorder();

        return $this;
    }

    public function image()
    {
        return $this->image;
    }

    public function width(): int
    {
        return $this->width;
    }

    public function height(): int
    {
        return $this->height;
    }

    public function destroyImage()
    {
        if($this->image) {
            $this->width = 0;
            $this->height = 0;

            imagedestroy($this->image);
        }
    }

    /**
     * Create appropriate size canvas
     */
    protected function createCanvas()
    {
        $w = 0;
        if($this->border instanceof Border){
            $w = $this->border->width();
        }

        $this->x += $w;
        $this->y += $w;

        $this->width = $this->x + $this->sideLength + $w;
        $this->height = $this->y + $this->sideLength + $w;
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    /**
     * Fill the square with color
     */
    protected function fill()
    {
        if($this->color instanceof Color) {
            $fillColor = imagecolorallocate(
                $this->image,
                $this->color->red(),
                $this->color->green(),
                $this->color->blue()
            );

            imagefilledrectangle($this->image, $this->x, $this->y, $this->x + $this->sideLength, $this->y + $this->sideLength, $fillColor);
        }
    }

    /**
     * Draw a border around the square
     */
    protected function drawBorder()
    {
        if($this->border instanceof Border) {
            $borderColor = imagecolorallocate(
                $this->image,
                $this->border->color()->red(),
                $this->border->color()->green(),
                $this->border->color()->blue()
            );

            imagesetthickness($this->image, $this->border->width());
            imagerectangle($this->image, $this->x, $this->y, $this->x + $this->sideLength, $this->y + $this->sideLength, $borderColor);
        }
    }
}