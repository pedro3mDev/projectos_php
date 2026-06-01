<?php

namespace App\DTOs;

use App\Entities\UserEntity;

class UserDTO
{
    public static function fromRequest(array $data): UserEntity
    {
        return new UserEntity(
            null,
            $data['name'],
            $data['email']
        );
    }
}