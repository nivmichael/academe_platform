<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;





    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'type_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'id',
	'subtype',
	'status',
	'first_name',
	'last_name', 
	'gender',
	'martial_status',
	'education_status',
	'email', 
	'password',
	'street_1',
	   	   
	'city',        	  
	'state',       	 
    'zipcode', 
    'country',    	  
	'phone_1',     	 
	    	  
	'mobile',      	 
	'date_of_birth', 
	'registration'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
