<?php

namespace App\Http\Controllers\V1;

use App\Repositories\UserRepository;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use JWTAuth;

class UserController extends Controller
{
	protected $userRepository;
	
	protected $validator;
	
    public function __construct(UserRepository $userRepository, UserValidator $validator)
	{
		$this->userRepository = $userRepository;
		$this->validator = $validator;
	}
	
	/**
	 * Register user
	 *
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function register(Request $request){
 		try {
 			$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);
 			$data = $request->all();
 			$data['password'] = Hash::make($data['password']);
 			$user = $this->userRepository->create($data);
			return response()->success($user);
		}
		catch (ValidatorException $exception){
			return response()->error($exception->getMessageBag(), 402);
		}
		catch (\Exception $exception){
			return response()->error('Register user error', 500);
		}
	}
	
	/**
	 * Update user information
	 * @param Request $request
	 *
	 * @return mixed
	 */
	public function update(Request $request){
		try {
			$this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
			$data = $request->all();
			$user = JWTAuth::parseToken()->toUser();
			$result = $this->userRepository->update($data, $user->id);
			return response()->success($result);
		}
		catch (ValidatorException $exception){
			return response()->error($exception->getMessageBag(), 402);
		}
		catch (\Exception $exception){
			return response()->error('Update user information error', 500);
		}
	}
}
