<?php

namespace App\Http\Controllers;

use App\Models\Shape\Factory;
use App\Models\Shape\ShapeCollector;
use App\Models\Shape\Option\Border;
use App\Models\Shape\Option\Color;
use Illuminate\Http\Request;

class ShapeController extends Controller
{
    public function index()
    {
        return view('shape');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Exception
     */
    public function draw(Request $request)
    {
        $collector = new ShapeCollector();

        $data = json_decode($request->get('data'));
        if(empty($data)){
            return response('Json parameters are invalid', 422);
        }

        foreach($data->shapes ?? [] as $shape){
            $object = Factory::build($shape->type);

            if(isset($shape->border) && isset($shape->border->color) && isset($shape->border->width)) {
                $object->setBorder(
                    new Border(
                        new Color($shape->border->color),
                        $shape->border->width
                    )
                );
            }

            if(isset($shape->color)){
                $object->setColor(
                    new Color($shape->color)
                );
            }

            $object->setParams((array)$shape);

            $collector->put($object);
        }

        $collector->merge();

        header('Content-Type: image/png');
        imagepng($collector->merged());

        $collector->destroy();

        exit();
    }
}
