<?php

declare(strict_types=1);

class UserNotFoundException extends DomainException
{
    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No se encontro un usuario con el ID: ' . $id);
    }
}
