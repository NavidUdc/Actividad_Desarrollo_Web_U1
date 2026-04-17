<?php

declare(strict_types=1);

final class ClassLoader
{
    private static array $classMap = array(
        'InvalidUserEmailException'    => 'src/Domain/Exceptions/InvalidUserEmailException.php',
        'InvalidUserIdException'       => 'src/Domain/Exceptions/InvalidUserIdException.php',
        'InvalidUserNameException'     => 'src/Domain/Exceptions/InvalidUserNameException.php',
        'InvalidUserPasswordException' => 'src/Domain/Exceptions/InvalidUserPasswordException.php',
        'InvalidUserRoleException'     => 'src/Domain/Exceptions/InvalidUserRoleException.php',
        'InvalidUserStatusException'   => 'src/Domain/Exceptions/InvalidUserStatusException.php',
        'UserAlreadyExistsException'   => 'src/Domain/Exceptions/UserAlreadyExistsException.php',
        'UserNotFoundException'        => 'src/Domain/Exceptions/UserNotFoundException.php',
        'InvalidCredentialsException'  => 'src/Domain/Exceptions/InvalidCredentialsException.php',
        'DomainException'              => 'src/Domain/Exceptions/DomainException.php',
        'UserRoleEnum'                 => 'src/Domain/Enums/UserRoleEnum.php',
        'UserStatusEnum'               => 'src/Domain/Enums/UserStatusEnum.php',
        'UserId'                       => 'src/Domain/ValueObjects/UserId.php',
        'UserName'                     => 'src/Domain/ValueObjects/UserName.php',
        'UserEmail'                    => 'src/Domain/ValueObjects/UserEmail.php',
        'UserPassword'                 => 'src/Domain/ValueObjects/UserPassword.php',
        'UserModel'                    => 'src/Domain/Models/UserModel.php',
        'DomainEvent'                  => 'src/Domain/Events/DomainEvent.php',
        'UserCreatedDomainEvent'       => 'src/Domain/Events/UserCreatedDomainEvent.php',
        'UserUpdatedDomainEvent'       => 'src/Domain/Events/UserUpdatedDomainEvent.php',
        'UserDeletedDomainEvent'       => 'src/Domain/Events/UserDeletedDomainEvent.php',
        'CreateUserUseCase'            => 'src/Application/Ports/In/CreateUserUseCase.php',
        'UpdateUserUseCase'            => 'src/Application/Ports/In/UpdateUserUseCase.php',
        'GetUserByIdUseCase'           => 'src/Application/Ports/In/GetUserByIdUseCase.php',
        'GetAllUsersUseCase'           => 'src/Application/Ports/In/GetAllUsersUseCase.php',
        'DeleteUserUseCase'            => 'src/Application/Ports/In/DeleteUserUseCase.php',
        'LoginUseCase'                 => 'src/Application/Ports/In/LoginUseCase.php',
        'SaveUserPort'                 => 'src/Application/Ports/Out/SaveUserPort.php',
        'UpdateUserPort'               => 'src/Application/Ports/Out/UpdateUserPort.php',
        'GetUserByIdPort'              => 'src/Application/Ports/Out/GetUserByIdPort.php',
        'GetUserByEmailPort'           => 'src/Application/Ports/Out/GetUserByEmailPort.php',
        'GetAllUsersPort'              => 'src/Application/Ports/Out/GetAllUsersPort.php',
        'DeleteUserPort'               => 'src/Application/Ports/Out/DeleteUserPort.php',
        'CreateUserCommand'            => 'src/Application/Services/Dto/Commands/CreateUserCommand.php',
        'UpdateUserCommand'            => 'src/Application/Services/Dto/Commands/UpdateUserCommand.php',
        'DeleteUserCommand'            => 'src/Application/Services/Dto/Commands/DeleteUserCommand.php',
        'LoginCommand'                 => 'src/Application/Services/Dto/Commands/LoginCommand.php',
        'GetUserByIdQuery'             => 'src/Application/Services/Dto/Queries/GetUserByIdQuery.php',
        'GetAllUsersQuery'             => 'src/Application/Services/Dto/Queries/GetAllUsersQuery.php',
        'CreateUserService'            => 'src/Application/Services/CreateUserService.php',
        'UpdateUserService'            => 'src/Application/Services/UpdateUserService.php',
        'GetUserByIdService'           => 'src/Application/Services/GetUserByIdService.php',
        'GetAllUsersService'           => 'src/Application/Services/GetAllUsersService.php',
        'DeleteUserService'            => 'src/Application/Services/DeleteUserService.php',
        'LoginService'                 => 'src/Application/Services/LoginService.php',
        'UserApplicationMapper'        => 'src/Application/Services/Mappers/UserApplicationMapper.php',
        'Connection'                   => 'src/Infrastructure/Adapters/Persistence/MySQL/Config/Connection.php',
        'UserPersistenceDto'           => 'src/Infrastructure/Adapters/Persistence/MySQL/Dto/UserPersistenceDto.php',
        'UserEntity'                   => 'src/Infrastructure/Adapters/Persistence/MySQL/Entity/UserEntity.php',
        'UserPersistenceMapper'        => 'src/Infrastructure/Adapters/Persistence/MySQL/Mapper/UserPersistenceMapper.php',
        'UserRepositoryMySQL'          => 'src/Infrastructure/Adapters/Persistence/MySQL/Repository/UserRepositoryMySQL.php',
        'CreateUserWebRequest'         => 'src/Infrastructure/Entrypoints/Web/Controllers/Dto/CreateUserRequest.php',
        'UpdateUserWebRequest'         => 'src/Infrastructure/Entrypoints/Web/Controllers/Dto/UpdateUserRequest.php',
        'LoginWebRequest'              => 'src/Infrastructure/Entrypoints/Web/Controllers/Dto/LoginWebRequest.php',
        'UserResponse'                 => 'src/Infrastructure/Entrypoints/Web/Controllers/Dto/UserResponse.php',
        'UserWebMapper'                => 'src/Infrastructure/Entrypoints/Web/Controllers/Mapper/UserWebMapper.php',
        'UserController'               => 'src/Infrastructure/Entrypoints/Web/Controllers/UserController.php',
        'WebRoutes'                    => 'src/Infrastructure/Entrypoints/Web/Controllers/Config/WebRoutes.php',
        'View'                         => 'src/Infrastructure/Entrypoints/Web/Presentation/View.php',
        'Flash'                        => 'src/Infrastructure/Entrypoints/Web/Presentation/Flash.php',
        'DependencyInjection'          => 'Common/DependencyInjection.php',
    );

    public static function register(): void
    {
        spl_autoload_register(array(self::class, 'loadClass'));
    }

    public static function loadClass(string $className): void
    {
        if (!isset(self::$classMap[$className])) {
            return;
        }
        $baseDir  = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        $filePath = $baseDir . self::$classMap[$className];
        if (!file_exists($filePath)) {
            throw new RuntimeException(
                sprintf('No se encontro el archivo para la clase %s en %s', $className, $filePath)
            );
        }
        require_once $filePath;
    }
}
