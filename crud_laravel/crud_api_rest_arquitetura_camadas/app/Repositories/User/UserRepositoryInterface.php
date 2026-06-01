<?php
namespace App\Repositories\User;

use App\Entities\UserEntity;

interface UserRepositoryInterface
{
    public function all();
    public function find(int $id): ?UserEntity;
    public function create(UserEntity $user): UserEntity;
    public function update(int $id, UserEntity $user): bool;
    public function delete(int $id): bool;
}

