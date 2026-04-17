<?php

declare(strict_types=1);

class InvalidUserPasswordException extends \InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('La contraseña no puede estar vacia.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('La contraseña debe tener al menos ' . $min . ' caracteres.');
    }
}
