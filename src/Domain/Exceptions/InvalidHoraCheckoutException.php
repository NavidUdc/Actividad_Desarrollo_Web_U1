<?php

class InvalidHoraCheckoutException extends InvalidArgumentException
{
    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato de hora de check-out es inválido: ' . $value);
    }

    public static function becauseValueIsEmpty(): self
    {
        return new self('La hora de check-out no puede estar vacía.');
    }
}