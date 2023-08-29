<?php

namespace App\Http\Controllers;

use App\Models\OrientacaoPaciente;
use Illuminate\Http\Request;

class Orientacao extends Controller
{
    public function print($id) {

        $orientacao = OrientacaoPaciente::find($id);

        return view('print.orientacao', compact(['orientacao']));


    }
}
