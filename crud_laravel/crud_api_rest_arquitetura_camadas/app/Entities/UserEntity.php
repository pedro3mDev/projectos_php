<?php

namespace App\Entities;

class UserEntity
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email
    ) {}
}