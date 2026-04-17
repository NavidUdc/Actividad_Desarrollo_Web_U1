<?php

declare(strict_types=1);

class InvalidUserNameException extends \InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre del usuario no puede estar vacio.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('El nombre debe tener al menos ' . $min . ' caracteres.');
    }
}
