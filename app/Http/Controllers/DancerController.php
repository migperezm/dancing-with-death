<?php

namespace App\Http\Controllers;

use App\Models\Dancer as Dancer;
use Illuminate\Http\Request;

class DancerController extends Controller
{

    public function getAll(Request $request)
    {        
        $dancer = Dancer::all();
        return $dancer;
    }

    public function postDancer(Request $request)
    {
        $dancer = new Dancer();
        $dancer->name = $request->name;
        $dancer->rut = $request->rut;
        $dancer->email = $request->email;

        $dancer->save();
        return $dancer;
    }
    public function getDancerById(Request $request)
    {
        $dancer = Dancer::findOrFail($request->id);
        return $dancer;
    }

    public function update(Request $request)
    {
        $dancer = Dancer::findOrFail($request->id);

        $dancer->name = $request->name;
        $dancer->rut = $request->rut;
        $dancer->email = $request->email;

        $dancer->update();

        return $dancer;
        //Esta función actualizará la tarea que hayamos seleccionado

    }

    public function destroy(Request $request)
    {
        $dancer = Dancer::destroy($request->id);
        return $dancer;
        //Esta función obtendra el id de la tarea que hayamos seleccionado y la borrará de nuestra BD
    }
}
