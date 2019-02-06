<?php

namespace App\Http\Controllers;

use App\Insect;
use Faker\Generator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class InsectsController extends Controller
{
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

    public function index()
    {
        return response(Insect::sorted()->get()->jsonSerialize(), Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $insect = Insect::findOrFail($id);

        if (isset($request->type))
        {
            $insect->type = $request->type;
        }

        $insect->save();

        return response(null, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        Insect::destroy($id);

        return response(null, Response::HTTP_OK);
    }
}
