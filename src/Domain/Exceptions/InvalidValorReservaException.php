<?php

class InvalidValorReservaException extends InvalidArgumentException
{

    public static function becauseValueIsEmpty(): self
    {
        return new self('El valor de la reserva no puede estar vacío.');
    }

    public static function becauseValueIsNotNumeric(string $value): self
    {
        return new self('El valor de la reserva debe ser numérico: ' . $value);
    }

    public static function becauseValueIsZeroOrNegative(float $value): self
    {
        return new self('El valor de la reserva debe ser mayor a 0: ' . $value);
    }
}