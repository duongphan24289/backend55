<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Contracts\ValidatorInterface;

class User
{
    protected $userRepository;

    protected $userValidator;

    protected $userMail;

    public function __construct(
        UserRepository $userRepository,
        UserValidator $userValidator,
        UserMail $userMail
    ) {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
        $this->userMail = $userMail;
    }

    public function register($request)
    {
        $this->userValidator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

        $user = $this->create($request);

        $this->userMail->register($user);
    }

    public function create($request)
    {
        return $this->userRepository->create([
            'name'		    => $request->input('name'),
            'name_kana'	=> $request->input('name_kana'),
            'email'		   => $request->input('email'),
            'password'	 => Hash::make($request->input('password')),
        ]);
    }

    public function update()
    {
    }

    public function delete()
    {
    }
}
