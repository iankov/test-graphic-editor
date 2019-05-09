<?php

namespace App\Models\Shape\Item;

use App\Models\Shape\Option\Border;
use App\Models\Shape\Option\Color;

interface ShapeInterface
{
    /**
     * Sets a shape border
     *
     * @param Border $border
     * @return self
     */
    public function setBorder(Border $border);

    /**
     * Sets a shape fill color
     *
     * @param Color $color
     * @return self
     */
    public function setColor(Color $color);

    /**
     * Set array of parameters
     *
     * @param array
     * @return self
     */
    public function setParams(array $params);

    /**
     * Draw a shape
     *
     * @return self
     */
    public function draw();

    /**
     * Return image resource
     *
     * @return resource|null
     */
    public function image();

    /**
     * Return width of an image
     *
     * @return int
     */
    public function width(): int;

    /**
     * Return height of an image
     *
     * @return int
     */
    public function height(): int;

    /**
     * Destroy drawn image
     */
    public function destroyImage();
}