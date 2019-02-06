<?php

namespace App\Http\Controllers;

use App\Insect;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class InsectsController
 * @package App\Http\Controllers
 */
class InsectsController extends Controller
{
    /**
     * @param Generator $faker
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function store(Generator $faker)
    {
        $insect = new Insect();
        $insect->name = $faker->name;

        $insect->type = $faker->randomElement(
            array(
                'ant',
                'bee',
                'bug',
                'butterfly',
                'dragonfly',
                'fly',
                'grasshopper',
                'ladybug',
                'mantis',
                'mosquito',
                'roach',
                'tick'
            )
        );
        $insect->save();

        return response($insect->jsonSerialize(), Response::HTTP_CREATED);
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function index()
    {
        return response(Insect::sorted()->get()->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function update(Request $request, $id)
    {
        $insect = Insect::findOrFail($id);

        if (!isset($request->op)) {
            if (isset($request->type)) {
                $insect->type = $request->type;
            }

            $insect->save();
        } else {
            if ("move_to_first_position" == $request->op) {

                $insect->moveBefore(Insect::sorted()->first());

            } else {
                if ("move_after_element" == $request->op && isset($request->predecessor_id)) {

                    $insect->moveAfter(Insect::find($request->predecessor_id));
                }
            }
        }

        return response($insect->jsonSerialize(), Response::HTTP_OK);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function destroy($id)
    {
        Insect::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
