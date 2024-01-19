<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function client(){
        return $this->hasOne(User::class,'id','client_id');
    }
    public function machine(){
        return $this->hasOne(Machine::class,'id','machine_id');
    }
    public function serviceDocs(){
        return $this->hasMany(ServiceDocs::class,'service_id','id');
    }

    public function engineer(){
        return $this->hasOne(User::class,'id','allocated_id');
    }
}
