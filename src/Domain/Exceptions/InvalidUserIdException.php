<?php

declare(strict_types=1);

class InvalidUserIdException extends \InvalidArgumentException
{
    public static function becauseValueIsEmpty(): self
    {
        return new self('El ID del usuario no puede estar vacio.');
    }
}
