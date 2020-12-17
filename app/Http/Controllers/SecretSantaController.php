<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameKey;
use App\Models\User;
use App\Models\SecretSantaMatch;

use Auth;

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

    public function GenerateMatches() {
        $matches = SecretSantaMatch::all();
        $numUsers = count($matches);

        $users = User::all();

        if($numUsers == 0) {
            $numbers = range(1, count($users));
            shuffle($numbers);

            for ($x = 0; $x < count($users); $x++) {
                $newMatch = new SecretSantaMatch();
                $newMatch->senderid = $users[$x]->id;
                $newMatch->receiverid = $numbers[$x];
                $newMatch->save();
            }
        } else {
            $numbers = range(1, $numUsers);
            shuffle($numbers);

            for ($x = 0; $x < $numUsers; $x++) {
                $matches[$x]->receiverid = $numbers[$x];
                $matches[$x]->save();
            } 
        }
    }

    public function SubmitKey(Request $request) {
        if(Auth::user() != null) {
            $newKey = new GameKey();

            $gamekey = $request->input("gamekey");
            $gamename = $request->input("gamename");

            if($gamekey != null && $gamename != null) {
                $newKey->ownerid = Auth::id();
                $newKey->gamename = $gamename;
                $newKey->key = $gamekey;
                $newKey->claimed = false;
                $newKey->save();

                return "SUCCESS";
            } else {
                return "Invalid key or game name";
            }
        } else {
            return "Not logged in";
        }
    }

    public function RemoveKey(Request $request) {
        if(Auth::user() != null) {
            $gameid = $request->input("gameid");
            $key = GameKey::where('id', $gameid)->first();

            if($key->ownerid == Auth::id()) {
                $key->delete();
                return "SUCCESS";
            } else {
                return "This key doesn't belong to you";
            }
        } else {
            return "Not logged in";
        }
    }
}
