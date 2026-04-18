<?php

class InvalidNombreHotelException extends InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El nombre del hotel no puede estar vacío.');
    }

    public static function becauseLengthIsTooShort(int $min): self
    {
        return new self('El nombre del hotel debe tener al menos ' . $min . ' caracteres.');
    }
}