<?php

declare(strict_types=1);

class InvalidUserEmailException extends \InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El email del usuario no puede estar vacio.');
    }

    public static function becauseFormatIsInvalid(string $email): self
    {
        return new self('El formato del email es invalido: ' . $email);
    }
}
