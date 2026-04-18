<?php

class InvalidFechasReservaException extends InvalidArgumentException
{
    public static function becauseFormatIsInvalid(string $value): self
    {
        return new self('El formato de fecha es inválido: ' . $value);
    }

    public static function becauseValueIsEmpty(): self
    {
        return new self('La fecha no puede estar vacía.');
    }

    public static function becauseStartDateIsGreaterThanEndDate(string $inicio, string $fin): self
    {
        return new self('La fecha de inicio (' . $inicio . ') no puede ser mayor que la fecha de fin (' . $fin . ').');
    }

    public static function becauseStartDateIsLowerThanToday(string $fecha): self
    {
        return new self('La fecha de inicio (' . $fecha . ') no puede ser anterior a hoy.');
    }
}