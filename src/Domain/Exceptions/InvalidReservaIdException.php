<?php

class InvalidReservaIdException extends InvalidArgumentException
{

    public static function becauseIsEmpty(): self{
        return new self('El id de la reserva no puede estar vacio');
    }
}