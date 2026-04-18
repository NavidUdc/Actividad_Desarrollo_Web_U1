<?php

use Couchbase\InvalidStateException;

class InvalidEstadoReservaException extends InvalidArgumentException
{

    public static function becauseValueIsInvalid(string $value): self
    {
        return new self('El estado "' . $value . '" no es un estado válido para la reserva.');
    }
}