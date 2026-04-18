<?php

class InvalidHoraCheckinException extends InvalidArgumentException
{
    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato de hora de check-in es inválido: ' . $value);
    }

    public static function becauseValueIsEmpty(): self
    {
        return new self('La hora de check-in no puede estar vacía.');
    }
}