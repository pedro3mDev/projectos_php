<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Entities\UserEntity;

class UserService implements UserServiceInterface
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function list()
    {
        return $this->repository->all();
    }
    
    public function get(int $id): ?UserEntity
    {
        return $this->repository->find($id);
    }

    public function store(UserEntity $user): UserEntity
    {
        return $this->repository->create($user);
    }

    public function update(int $id, UserEntity $user): bool
    {
        return $this->repository->update($id, $user);
    }

    public function destroy(int $id): bool
    {
        return $this->repository->delete($id);
    }
    
}