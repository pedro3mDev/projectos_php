app/
 ├── Domain/
 │    └── User/
 │         ├── Entities/
 │         │     └── User.php
 │         ├── ValueObjects/
 │         │     └── Email.php
 │         ├── Repositories/
 │         │     └── UserRepositoryInterface.php
 │         └── Services/
 │               └── UserDomainService.php
 │
 ├── Application/
 │    └── User/
 │         ├── DTOs/
 │         │     └── UserDTO.php
 │         └── Services/ 
 │               └── UserService.php
 │
 ├── Infrastructure/
 │    └── Persistence/
 │         └── Eloquent/
 │              ├── Models/
 │              │     └── UserModel.php
 │              └── Repositories/
 │                    └── UserRepository.php
 │
 └── Http/
 │    └── Controllers/
 │         └── Api/
 │              └── UserController.php
