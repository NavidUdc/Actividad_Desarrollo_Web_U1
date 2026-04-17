<?php

declare(strict_types=1);

final class UpdateUserService implements UpdateUserUseCase
{
    private UpdateUserPort     $updateUserPort;
    private GetUserByIdPort    $getUserByIdPort;
    private GetUserByEmailPort $getUserByEmailPort;

    public function __construct(
        UpdateUserPort     $updateUserPort,
        GetUserByIdPort    $getUserByIdPort,
        GetUserByEmailPort $getUserByEmailPort
    ) {
        $this->updateUserPort     = $updateUserPort;
        $this->getUserByIdPort    = $getUserByIdPort;
        $this->getUserByEmailPort = $getUserByEmailPort;
    }

    public function execute(UpdateUserCommand $command): UserModel
    {
        $userId      = new UserId($command->getId());
        $currentUser = $this->getUserByIdPort->getById($userId);
        if ($currentUser === null) {
            throw UserNotFoundException::becauseIdWasNotFound($userId->value());
        }

        $newEmail          = new UserEmail($command->getEmail());
        $userWithSameEmail = $this->getUserByEmailPort->getByEmail($newEmail);
        if ($userWithSameEmail !== null && !$userWithSameEmail->id()->equals($userId)) {
            throw UserAlreadyExistsException::becauseEmailAlreadyExists($newEmail->value());
        }

        $password = ($command->getPassword() !== '')
            ? UserPassword::fromPlainText($command->getPassword())
            : $currentUser->password();

        $userToUpdate = new UserModel(
            $userId,
            new UserName($command->getName()),
            $newEmail,
            $password,
            $command->getRole(),
            $command->getStatus()
        );

        return $this->updateUserPort->update($userToUpdate);
    }
}
