<?php

namespace App\Models\Shape;

use App\Models\Shape\Item\Circle;
use App\Models\Shape\Item\ShapeInterface;
use App\Models\Shape\Item\Square;

class Factory
{
    /**
     * @param string $shape
     * @return ShapeInterface
     * @throws \Exception
     */
    public static function build(string $shape): ShapeInterface
    {
        switch ($shape) {
            case 'circle':
                $obj = new Circle();
                break;

            case 'square':
                $obj = new Square();
                break;

            default:
                throw new \Exception('Factory can not create a shape with name "'.$shape.'"');
        }

        return $obj;
    }
}