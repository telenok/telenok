<?php namespace App\Telenok\Core\Model\User;

class User extends \Telenok\Core\Model\User\User implements \Illuminate\Contracts\Auth\CanResetPassword {
	
	use \Illuminate\Auth\Passwords\CanResetPassword;
}