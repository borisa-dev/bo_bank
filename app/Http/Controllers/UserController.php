<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\Repositories\IUser;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(public IUser $user)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection($this->user->getAllWithAccounts());
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $this->user->update($id, $request->validated());
            return response()->json(['success' => 'ok'])->setStatusCode(Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()
                ->json(['message' => $th->getMessage()])
                ->setStatusCode(Response::HTTP_BAD_REQUEST);
        }
    }

}
