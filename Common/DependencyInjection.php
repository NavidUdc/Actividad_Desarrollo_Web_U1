<?php

declare(strict_types=1);

require_once __DIR__ . '/ClassLoader.php';

final class DependencyInjection
{
    public static function boot(): void
    {
        ClassLoader::register();
    }

    public static function getConnection(): Connection
    {
        ClassLoader::loadClass('Connection');
        return new Connection(
            host: '127.0.0.1',
            port: 3306,
            database: 'crud_hexagonal',
            username: 'root',
            password: '1234',
            charset: 'utf8mb4'
        );
    }

    public static function getPdo(): \PDO
    {
        return self::getConnection()->createPdo();
    }

    public static function getUserPersistenceMapper(): UserPersistenceMapper
    {
        ClassLoader::loadClass('UserPersistenceMapper');
        return new UserPersistenceMapper();
    }

    public static function getUserRepository(): UserRepositoryMySQL
    {
        ClassLoader::loadClass('UserRepositoryMySQL');
        return new UserRepositoryMySQL(self::getPdo(), self::getUserPersistenceMapper());
    }

    public static function getCreateUserUseCase(): CreateUserUseCase
    {
        ClassLoader::loadClass('CreateUserService');
        $repo = self::getUserRepository();
        return new CreateUserService($repo, $repo);
    }

    public static function getUpdateUserUseCase(): UpdateUserUseCase
    {
        ClassLoader::loadClass('UpdateUserService');
        $repo = self::getUserRepository();
        return new UpdateUserService($repo, $repo, $repo);
    }

    public static function getDeleteUserUseCase(): DeleteUserUseCase
    {
        ClassLoader::loadClass('DeleteUserService');
        $repo = self::getUserRepository();
        return new DeleteUserService($repo, $repo);
    }

    public static function getGetUserByIdUseCase(): GetUserByIdUseCase
    {
        ClassLoader::loadClass('GetUserByIdService');
        return new GetUserByIdService(self::getUserRepository());
    }

    public static function getGetAllUsersUseCase(): GetAllUsersUseCase
    {
        ClassLoader::loadClass('GetAllUsersService');
        return new GetAllUsersService(self::getUserRepository());
    }

    public static function getLoginUseCase(): LoginUseCase
    {
        ClassLoader::loadClass('LoginService');
        return new LoginService(self::getUserRepository());
    }

    public static function getUserWebMapper(): UserWebMapper
    {
        ClassLoader::loadClass('UserWebMapper');
        return new UserWebMapper();
    }

    public static function getUserController(): UserController
    {
        ClassLoader::loadClass('UserController');
        return new UserController(
            self::getCreateUserUseCase(),
            self::getUpdateUserUseCase(),
            self::getGetUserByIdUseCase(),
            self::getGetAllUsersUseCase(),
            self::getDeleteUserUseCase(),
            self::getUserWebMapper()
        );
    }


    // Reserva

    public static function getReservaPersistenceMapper(): ReservaPersistenceMapper
    {
        ClassLoader::loadClass('ReservaPersistenceMapper');
        return new ReservaPersistenceMapper();
    }

    public static function getReservaRepository(): ReservaRepositoryMySQL
    {
        ClassLoader::loadClass('ReservaRepositoryMySQL');
        return new ReservaRepositoryMySQL(self::getPdo(), self::getReservaPersistenceMapper());
    }

    public static function getCreateReservaUseCase(): CreateReservaUseCase
    {
        ClassLoader::loadClass('CreateReservaService');
        return new CreateReservaService(self::getReservaRepository());
    }

    public static function getUpdateReservaUseCase(): UpdateReservaUseCase
    {
        ClassLoader::loadClass('UpdateReservaService');
        $repo = self::getReservaRepository();
        return new UpdateReservaService($repo, $repo);
    }

    public static function getDeleteReservaUseCase(): DeleteReservaUseCase
    {
        ClassLoader::loadClass('DeleteReservaService');
        $repo = self::getReservaRepository();
        return new DeleteReservaService($repo, $repo);
    }

    public static function getGetReservaByIdUseCase(): GetReservaByIdUseCase
    {
        ClassLoader::loadClass('GetReservaByIdService');
        return new GetReservaByIdService(self::getReservaRepository());
    }

    public static function getGetAllReservasUseCase(): GetAllReservasUseCase
    {
        ClassLoader::loadClass('GetAllReservaService');
        return new GetAllReservaService(self::getReservaRepository());
    }

    public static function getChangeEstadoReservaUseCase(): ChangeEstadoReservaUseCase
    {
        ClassLoader::loadClass('ChangeEstadoReservaService');
        $repo = self::getReservaRepository();
        return new ChangeEstadoReservaService($repo, $repo);
    }

    public static function getReservaWebMapper(): ReservaWebMapper
    {
        ClassLoader::loadClass('ReservaWebMapper');
        return new ReservaWebMapper();
    }

    public static function getReservaController(): ReservaController
    {
        ClassLoader::loadClass('ReservaController');
        return new ReservaController(
            self::getCreateReservaUseCase(),
            self::getUpdateReservaUseCase(),
            self::getDeleteReservaUseCase(),
            self::getGetReservaByIdUseCase(),
            self::getGetAllReservasUseCase(),
            self::getChangeEstadoReservaUseCase(),
            self::getReservaWebMapper()
        );
    }
}
