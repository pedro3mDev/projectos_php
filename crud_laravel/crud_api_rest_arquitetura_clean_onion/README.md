app
├── Domain
│   └── User
│       ├── Entity
│       │   └── User.php
│       ├── Repository
│       │   └── UserRepositoryInterface.php
│
├── Application
│   └── User
│       ├── DTO
│       │   └── CreateUserDTO.php
│       ├── UseCase
│       │   ├── CreateUserUseCase.php
│       │   ├── ListUsersUseCase.php
│       │   ├── UpdateUserUseCase.php
│       │   └── DeleteUserUseCase.php 
│
├── Infrastructure
│   └── Persistence
│       └── Eloquent
│           ├── Models
│           │   └── UserModel.php
│           └── Repositories
│               └── UserRepository.php
│
├── Http
│   └── Controllers
│       └── Api
│           └── UserController.php
│
└── Providers
    └── RepositoryServiceProvider.php
