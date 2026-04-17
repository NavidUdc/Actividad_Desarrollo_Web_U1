<?php

namespace Infrastructure\Persistence\MySQL;

use Application\Services\CreateUserService;
use Application\Services\DeleteUserService;
use Application\Services\GetAllUsersService;
use Application\Services\GetUserByIdService;
use Application\Services\LoginService;
use Application\Services\UpdateUserService;

class Container
{
    private static ?UserRepositoryMySQL $repository = null;

    private static function repository(): UserRepositoryMySQL
    {
        if (self::$repository === null) {
            self::$repository = new UserRepositoryMySQL();
        }
        return self::$repository;
    }

    public static function createUserService(): CreateUserService
    {
        return new CreateUserService(
            self::repository(),
            self::repository()
        );
    }

    public static function updateUserService(): UpdateUserService
    {
        return new UpdateUserService(
            self::repository(),
            self::repository()
        );
    }

    public static function deleteUserService(): DeleteUserService
    {
        return new DeleteUserService(
            self::repository(),
            self::repository()
        );
    }

    public static function getUserByIdService(): GetUserByIdService
    {
        return new GetUserByIdService(self::repository());
    }

    public static function getAllUsersService(): GetAllUsersService
    {
        return new GetAllUsersService(self::repository());
    }

    public static function loginService(): LoginService
    {
        return new LoginService(self::repository());
    }
}
