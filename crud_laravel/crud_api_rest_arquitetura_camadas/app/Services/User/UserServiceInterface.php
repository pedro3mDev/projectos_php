<?php

namespace App\Services\User;

use App\Entities\UserEntity;

interface UserServiceInterface
{
    public function list();
    public function get(int $id): ?UserEntity;
    public function store(UserEntity $user): UserEntity;
    public function update(int $id, UserEntity $user): bool;
    public function destroy(int $id): bool;
}

