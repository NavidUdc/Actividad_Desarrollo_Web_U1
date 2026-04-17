<?php

namespace Infrastructure\Entrypoints\Web\Controllers\Mapper;

use Application\Commands\CreateUserCommand;
use Application\Commands\DeleteUserCommand;
use Application\Commands\LoginCommand;
use Application\Commands\UpdateUserCommand;
use Domain\Models\UserModel;
use Infrastructure\Entrypoints\Web\Controllers\Dto\CreateUserRequest;
use Infrastructure\Entrypoints\Web\Controllers\Dto\LoginWebRequest;
use Infrastructure\Entrypoints\Web\Controllers\Dto\UpdateUserRequest;
use Infrastructure\Entrypoints\Web\Controllers\Dto\UserResponse;

class UserWebMapper
{
    public function toCreateCommand(CreateUserRequest $req): CreateUserCommand
    {
        return new CreateUserCommand(
            $req->name,
            $req->email,
            $req->password,
            $req->roleId
        );
    }

    public function toUpdateCommand(UpdateUserRequest $req): UpdateUserCommand
    {
        return new UpdateUserCommand(
            $req->id,
            $req->name,
            $req->email,
            $req->password,
            $req->roleId,
            $req->status
        );
    }

    public function toDeleteCommand(string $id): DeleteUserCommand
    {
        return new DeleteUserCommand($id);
    }

    public function toLoginCommand(LoginWebRequest $req): LoginCommand
    {
        return new LoginCommand($req->email, $req->password);
    }

    public function toResponse(UserModel $user): UserResponse
    {
        return new UserResponse(
            $user->id()->value(),
            $user->name()->value(),
            $user->email()->value(),
            $user->role()->value,
            $user->role()->name,
            $user->status()->value
        );
    }
}
