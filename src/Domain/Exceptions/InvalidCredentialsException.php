<?php

declare(strict_types=1);

class InvalidCredentialsException extends DomainException
{
    public static function becauseCredentialsAreInvalid(): self
    {
        return new self('Correo o contraseña incorrectos.');
    }

    public static function becauseUserIsNotActive(): self
    {
        return new self('Tu cuenta no esta activa. Contacta al administrador.');
    }
}
