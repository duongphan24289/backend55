<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserValidator extends LaravelValidator
{

    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
        	'name'		=> 'required',
			'email'		=> 'required|email|unique:users,email',
			'password' 	=> 'required|min:8|max:20'
		],
        ValidatorInterface::RULE_UPDATE => [
        	'email'		=> 'email|unique:users,email'
		],
   ];
    
    protected $attributes = [];
    
    protected $messages = [
    	'required'	=> 'The :attribute field is required.',
		'email'		=> 'The :attribute field is email.',
		'min'		=> 'The :attribute field has min 8 character.',
		'max'		=> 'The :attribute field has max 20 character.',
		'unique'	=> 'The :attribute field already exist.'
	];
 
 
}
