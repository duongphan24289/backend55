<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\ApiController;
use App\Repositories\TodoRepository;

class TodoController extends ApiController
{
    protected $todoRepository;

    public function __construct(TodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Get list todos.
     *
     * @return mixed
     */
    public function index()
    {
        $todos = $this->todoRepository->all();

        return response()->success($todos);
    }
}
