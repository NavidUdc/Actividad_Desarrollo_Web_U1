<?php

class InvalidNumerosAcompanantesException extends InvalidArgumentException
{
    public static function becauseValueIsNegative(int $value): self
    {
        return new self('El número de acompañantes no puede ser negativo: ' . $value);
    }

    public static function becauseValueIsNotNumeric(string $value): self
    {
        return new self('El número de acompañantes debe ser numérico: ' . $value);
    }
}