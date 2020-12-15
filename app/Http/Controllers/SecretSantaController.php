<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameKey;
use App\Models\User;

class SecretSantaController extends Controller
{
    public function ReturnWinner() {
        $keys = GameKey::where("claimed", false)->get();

        if(count($keys) == 0) {
            $data = array(
                'outro' => true
            );

            return json_encode($data);
        }

        $randomKey = $keys[rand(0,count($keys)-1)];

        $owner = $randomKey->owner;
        $winner = $randomKey->owner->secretmatch->receiver;

        $data = array(
            'name' => $winner->name,
            'key' => $randomKey->key,
            'gamename' => $randomKey->gamename,
            "discordid" => $winner->discordid
        );

        $randomKey->claimed = true;
        $randomKey->save();

        return json_encode($data);
    }

    public function ResetKeys() {
        $keys = GameKey::all();
        foreach($keys as $key) {
            $key->claimed = false;
            $key->save();
        }
    }
}
