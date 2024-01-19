<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    use HasFactory;
    public function client(){
        return $this->hasOne(User::class,'id','client_id');
    }
    public function machine(){
        return $this->hasOne(Machine::class,'id','machine_id');
    }
    public function multipleMachine(){
        return $this->hasMany(PurchaseHistory::class,'client_id','client_id');
    }
}
