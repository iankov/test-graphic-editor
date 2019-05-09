<?php

namespace App\Models\Shape;

use App\Models\Shape\Item\ShapeInterface;

class ShapeCollector
{
    protected $shapes = [];
    protected $merged;

    /**
     * Add new image resource into collection
     *
     * @param ShapeInterface $shape
     * @return ShapeCollector
     */
    public function put(ShapeInterface $shape)
    {
        $this->shapes[] = $shape;

        return $this;
    }

    /**
     * Merge all images in the collection into a single image
     */
    public function merge()
    {
        $newWidth = 0;
        $newHeight = 0;

        foreach($this->shapes as $shape){
            if(!$shape->image()){
                $shape->draw();
            }

            $newWidth = max($newWidth, $shape->width());
            $newHeight += $shape->height();
        }

        $this->merged = imagecreatetruecolor($newWidth, $newHeight);

        $x = $y = 0;
        foreach($this->shapes as $shape){
            imagecopy($this->merged, $shape->image(), $x, $y, 0, 0, $shape->width(), $shape->height());

            $y += $shape->height();
        }

        return $this;
    }

    /**
     * Return merged image resource
     *
     * @return resource
     */
    public function merged()
    {
        return $this->merged;
    }

    /**
     * Destroy all image resources
     */
    public function destroy()
    {
        foreach($this->shapes as $shape){
            $shape->destroyImage();
        }

        imagedestroy($this->merged);

        $this->shapes = [];
    }
}