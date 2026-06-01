<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DTOs\UserDTO;
use App\Services\User\UserServiceInterface;

class UserController extends Controller
{
    public function __construct(
        protected UserServiceInterface $service
    ) {}

    public function index()
    {
        return response()->json($this->service->list());
    }

    public function store(Request $request)
    {
        $user = UserDTO::fromRequest($request->all());
        return response()->json($this->service->store($user), 201);
    }


    public function show($id)
    {
        return response()->json($this->service->get($id));
    }


    public function update(Request $request, $id)
    {
        $user = UserDTO::fromRequest($request->all());
        return response()->json($this->service->update($id, $user));
    }


    public function destroy($id)
    {
        return response()->json($this->service->destroy($id));
    }

    
}