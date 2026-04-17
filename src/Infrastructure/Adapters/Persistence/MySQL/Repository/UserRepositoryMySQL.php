<?php

declare(strict_types=1);

final class UserRepositoryMySQL implements
    SaveUserPort,
    UpdateUserPort,
    GetUserByIdPort,
    GetUserByEmailPort,
    GetAllUsersPort,
    DeleteUserPort
{
    private \PDO                  $pdo;
    private UserPersistenceMapper $mapper;

    public function __construct(\PDO $pdo, UserPersistenceMapper $mapper)
    {
        $this->pdo    = $pdo;
        $this->mapper = $mapper;
    }

    public function save(UserModel $user): UserModel
    {
        $dto  = $this->mapper->fromModelToDto($user);
        $sql  = 'INSERT INTO users (id, name, email, password, role, status, created_at, updated_at)
                 VALUES (:id, :name, :email, :password, :role, :status, NOW(), NOW())';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            ':id'       => $dto->id(),
            ':name'     => $dto->name(),
            ':email'    => $dto->email(),
            ':password' => $dto->password(),
            ':role'     => $dto->role(),
            ':status'   => $dto->status(),
        ));
        $saved = $this->getById(new UserId($dto->id()));
        if ($saved === null) {
            throw new \RuntimeException('El usuario no pudo recuperarse despues de guardarse.');
        }
        return $saved;
    }

    public function update(UserModel $user): UserModel
    {
        $dto  = $this->mapper->fromModelToDto($user);
        $sql  = 'UPDATE users SET name=:name, email=:email, password=:password,
                 role=:role, status=:status, updated_at=NOW() WHERE id=:id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            ':id'       => $dto->id(),
            ':name'     => $dto->name(),
            ':email'    => $dto->email(),
            ':password' => $dto->password(),
            ':role'     => $dto->role(),
            ':status'   => $dto->status(),
        ));
        $updated = $this->getById(new UserId($dto->id()));
        if ($updated === null) {
            throw new \RuntimeException('El usuario no pudo recuperarse despues de actualizarse.');
        }
        return $updated;
    }

    public function getById(UserId $userId): ?UserModel
    {
        $sql  = 'SELECT id, name, email, password, role, status, created_at, updated_at
                 FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(':id' => $userId->value()));
        $row = $stmt->fetch();
        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    public function getByEmail(UserEmail $email): ?UserModel
    {
        $sql  = 'SELECT id, name, email, password, role, status, created_at, updated_at
                 FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(':email' => $email->value()));
        $row = $stmt->fetch();
        return $row === false ? null : $this->mapper->fromRowToModel($row);
    }

    public function getAll(): array
    {
        $sql  = 'SELECT id, name, email, password, role, status, created_at, updated_at
                 FROM users ORDER BY name ASC';
        $stmt = $this->pdo->query($sql);
        $rows = $stmt->fetchAll();
        return $this->mapper->fromRowsToModels($rows);
    }

    public function delete(UserId $userId): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = :id');
        $stmt->execute(array(':id' => $userId->value()));
    }
}
