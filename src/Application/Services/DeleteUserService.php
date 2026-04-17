<?php

declare(strict_types=1);

final class DeleteUserService implements DeleteUserUseCase
{
    private DeleteUserPort  $deleteUserPort;
    private GetUserByIdPort $getUserByIdPort;

    public function __construct(
        DeleteUserPort  $deleteUserPort,
        GetUserByIdPort $getUserByIdPort
    ) {
        $this->deleteUserPort  = $deleteUserPort;
        $this->getUserByIdPort = $getUserByIdPort;
    }

    public function execute(DeleteUserCommand $command): void
    {
        $userId      = UserApplicationMapper::fromDeleteCommandToUserId($command);
        $existingUser = $this->getUserByIdPort->getById($userId);
        if ($existingUser === null) {
            throw UserNotFoundException::becauseIdWasNotFound($userId->value());
        }
        $this->deleteUserPort->delete($userId);
    }
}
