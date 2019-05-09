<?php

namespace App\Models\Shape\Item;

use App\Models\Shape\Option\Border;
use App\Models\Shape\Option\Color;

class Circle implements ShapeInterface
{
    protected $border, $color, $radius, $image;

    protected $x = 0;
    protected $y = 0;
    protected $width = 0;
    protected $height = 0;

    public function __construct(int $radius = 100)
    {
        $this->radius = $radius;
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

        if(isset($params['radius'])){
            $this->setRadius($params['radius']);
        }
    }

    public function setRadius(int $radius)
    {
        $this->radius = $radius;

        return $this;
    }

    public function setPerimeter(int $perimeter)
    {
        $this->radius = ceil($perimeter / (2 * pi()));

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

        $this->x = $this->radius + $w;
        $this->y = $this->radius + $w;

        $this->width = $this->x + $this->radius + $w + 1;
        $this->height = $this->y + $this->radius + $w + 1;
        $this->image = imagecreatetruecolor($this->width, $this->height);
    }

    /**
     * Fill the circle with color
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

            imagefilledarc($this->image, $this->x, $this->y, $this->radius * 2, $this->radius * 2, 0, 360, $fillColor, IMG_ARC_PIE);
        }
    }

    /**
     * Draw a border around the circle
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

            for($i = 1; $i <= $this->border->width() * 2; $i++){
                imagearc($this->image, $this->x, $this->y, $this->radius * 2 + $i, $this->radius * 2 + $i, 0, 360, $borderColor);

                //make the border smoother
                imagearc($this->image, $this->x, $this->y, $this->radius * 2 + $i, $this->radius * 2 + $i - 1, 0, 360, $borderColor);
                imagearc($this->image, $this->x, $this->y, $this->radius * 2 + $i - 1, $this->radius * 2 + $i, 0, 360, $borderColor);
            }
        }
    }
}