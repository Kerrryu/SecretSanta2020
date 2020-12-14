<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretSantaController extends Controller
{
    public function ReturnWinner() {
        $data = array(
            'name' => "Seby",
            'key' => "TESTKEYVALUEHERE",
            'gamename' => "Friends With Benefits"
        );

        return json_encode($data);
    }
}
