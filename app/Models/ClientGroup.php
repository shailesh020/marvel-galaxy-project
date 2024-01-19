<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getClient($client_id){
        return User::find($client_id);
    }
}
