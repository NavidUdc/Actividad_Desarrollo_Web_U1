<?php

class ReservaNotFoundException extends DomainException
{

    public static function becauseIdWasNotFound(string $id): self
    {
        return new self('No se encontró una reserva con el ID: ' . $id);
    }
}