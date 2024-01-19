<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apitoken extends Model
{
    use HasFactory;
    protected $table = "personal_access_tokens";

    public static function checkToken($user_id)
    {
        $token = Apitoken::where('tokenable_id', $user_id)->first();
        return $token;
    }
}