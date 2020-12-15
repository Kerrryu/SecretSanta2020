<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class GameKey extends Model
{
    use HasFactory;

    public $table = 'game_keys';

    public function owner() {
        return $this->hasOne("App\Models\User", "id", "ownerid");
    }
}
