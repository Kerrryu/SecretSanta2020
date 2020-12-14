<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SecretSantaController extends Controller
{
    public function ReturnWinner() {
        $data = array(
            'name' => "Seby",
            'key' => "TESTKEYVALUEHERE",
            'gamename' => "Friends With Benefits",
            "discordid" => "1234567890"
        );

        return json_encode($data);
    }
}
