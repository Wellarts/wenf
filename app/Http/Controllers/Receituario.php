<?php

namespace App\Http\Controllers;

use App\Models\Receituario as ModelsReceituario;
use Illuminate\Http\Request;

class Receituario extends Controller
{
    public function print($id) {

        $receituario = ModelsReceituario::find($id);

        return view('print.receituario', compact(['receituario']));


    }
}
