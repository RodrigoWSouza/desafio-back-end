<?php

namespace App\Repository\Eloquent;

use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Http\Response;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function create(array $attributes)
    {
        try {
            $this->model->create($attributes);
        	return response()->json(['success' => 'Account successfully created!']);
        } catch (\Throwable $th) {
            return response()->json([$th], Response::HTTP_BAD_REQUEST);
        }
    }
}
