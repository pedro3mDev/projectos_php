app/
├── Domain/
│   └── User/
│       ├── Entity/
│       │   └── User.php
│       ├── Port/
│       │   ├── Inbound/
│       │   │   └── UserServiceInterface.php
│       │   └── Outbound/
│       │       └── UserRepositoryInterface.php
│       └── Service/
│           └── UserService.php
│
├── Application/
│   └── User/
│       └── DTO/
│           └── CreateUserDTO.php
│
├── Infrastructure/
│   └── Persistence/
│       └── Eloquent/
│           ├── Models/
│           │   └── UserModel.php
│           └── Repositories/
│               └── UserRepository.php
│
├── Adapters/
│   └── Http/
│       └── Controllers/ 
│           └── UserController.php
│
└── Providers/
    └── UserServiceProvider.php
