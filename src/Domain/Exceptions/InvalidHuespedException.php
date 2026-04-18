<?php

class InvalidHuespedException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre del huesped no puede estar vacío.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('El nombre del huesped debe tener al menos ' . $min . ' caracteres.');
    }
}