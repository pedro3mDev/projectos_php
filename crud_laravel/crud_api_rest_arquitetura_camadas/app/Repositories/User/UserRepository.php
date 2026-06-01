<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Entities\UserEntity;


class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find(int $id): ?UserEntity
    {
        $user = User::find($id);
        if (!$user) return null;
        return new UserEntity($user->id, $user->name, $user->email);
    }

    public function create(UserEntity $user): UserEntity
    {
        $created = User::create([
            'name' => $user->name,
            'email' => $user->email
        ]);
        return new UserEntity($created->id, $created->name, $created->email);
    }

    public function update(int $id, UserEntity $user): bool
    {
        return User::where('id', $id)->update([
            'name' => $user->name,
            'email' => $user->email
        ]);
    }

    public function delete(int $id): bool
    {
        return User::destroy($id);
    }
    
}