<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class UsersToken extends Model
{

	const TOKEN_EXPIRY=10; //constant to set a token expiry time in secs 

   protected $table='users_token';

   protected $fillable=['token'];

   public function isExpired()
   {
   	
   		return $this->created_at->diffInSeconds(Carbon::now()) > self::TOKEN_EXPIRY;

   }

   public function getRouteKeyName()
   {
   	return 'token';
   }

   public function user()
   {
   		
   		return $this->belongsTo(User::class);
   }
}
