<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Services\User as UserService;
use App\Validators\UserValidator;
use Illuminate\Http\Request;
use JWTAuth;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class UserController extends Controller
{
    protected $userRepository;

    protected $validator;

    protected $userService;

    public function __construct(
        UserRepository $userRepository,
        UserValidator $validator,
        UserService $userService
    ) {
        $this->userRepository = $userRepository;
        $this->validator = $validator;
        $this->userService = $userService;
    }

    /**
     * Register user.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function register(Request $request)
    {
        try {
            $this->userService->register($request);

            return response()->success(true);
        } catch (ValidatorException $exception) {
            return response()->error($exception->getMessageBag(), 402);
        } catch (\Exception $exception) {
            return response()->error('Register user error', 500);
        }
    }

    /**
     * Update user information.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function update(Request $request)
    {
        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);
            $data = $request->all();
            $user = JWTAuth::parseToken()->toUser();
            $result = $this->userRepository->update($data, $user->id);

            return response()->success($result);
        } catch (ValidatorException $exception) {
            return response()->error($exception->getMessageBag(), 402);
        } catch (\Exception $exception) {
            return response()->error('Update user information error', 500);
        }
    }
}
