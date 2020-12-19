<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameKey;
use App\Models\User;
use App\Models\SecretSantaMatch;
use App\Models\SantaUser;

use Auth;

class SecretSantaController extends Controller
{
    public function ReturnWinner() {
        $userqueue = SantaUser::where("id", 1)->first();

        if($userqueue == null) {
            $userqueue = new SantaUser();
            $userqueue->name = str_shuffle("1234567");
            $userqueue->curIndex = 0;
            $userqueue->save();
        }

        if($userqueue->curIndex >= (count(User::all()) - 1)) {
            $userqueue->name = str_shuffle("1234567");
            $userqueue->curIndex = 0;
            $userqueue->save();
        } else {
            $userqueue->curIndex = $userqueue->curIndex + 1;
            $userqueue->save();
        }

        $winnerid = $userqueue->name[$userqueue->curIndex];

        $keys = GameKey::where("claimed", false)->where("ownerid", "!=", $winnerid)->get();
        $unclaimedkeys = GameKey::where("claimed", false)->get();

        if(count($unclaimedkeys) == 0) {
            $data = array(
                'outro' => true
            );

            return json_encode($data);
        }

        if(count($keys) != 0) {
            $randomKey = $keys[rand(0,count($keys)-1)];

            $owner = $randomKey->owner;
            $winner = User::where('id', $winnerid)->first();

            $data = array(
                'name' => $winner->name,
                'key' => $randomKey->key,
                'gamename' => $randomKey->gamename,
                "discordid" => $winner->discordid
            );

            $randomKey->claimed = true;
            $randomKey->save();

            return json_encode($data);
        } else {
            $winner = User::where('id', $winnerid)->first();
            $data = array(
                'name' => $winner->name,
                'key' => "OUT OF KEYS",
                'gamename' => "No more keys left for you",
                "discordid" => "$winner->discordid"
            );

            return json_encode($data);
        }
    }

    public function ResetKeys() {
        $keys = GameKey::all();
        foreach($keys as $key) {
            $key->claimed = false;
            $key->save();
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
