<?php

declare(strict_types=1);

class InvalidUserStatusException extends \InvalidArgumentException
{
    public static function becauseValueIsInvalid(string $value): self
    {
        return new self('El estado "' . $value . '" no es un estado valido.');
    }
}
