<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecretSantaMatch extends Model
{
    use HasFactory;

    public $table = 'SecretSantaMatch';

    public function sender() {
        return $this->hasOne("App\Models\User", "id", "senderid");
    }

    public function receiver() {
        return $this->hasOne("App\Models\User", "id", "receiverid");
    }
}
