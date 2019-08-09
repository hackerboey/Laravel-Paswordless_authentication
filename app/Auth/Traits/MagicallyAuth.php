<?php

namespace App\Auth\Traits;
use App\UsersToken; 
use Mail;
use App\Mail\MagicLoginRequested;

/**
 * 
 */
trait MagicallyAuth
{
	
	public function storeToken()
	{	
		$this->token()->delete();
		$this->token()->create([
			'token'=>str_random(255),
		]);

		return $this;
	}

	public function sendMagicLink(array $options)
	{
		Mail::to($this)->send(new MagicLoginRequested($this, $options));
	}

	public function token()
	{
		
		return $this->hasOne(UsersToken::class);
	}

}