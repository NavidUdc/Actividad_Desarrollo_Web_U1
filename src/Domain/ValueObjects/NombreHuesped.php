<?php
declare(strict_types=1);
require_once __DIR__ . "/../Exceptions/InvalidHuespedException.php";
class NombreHuesped
{
    private const MIN_LENGTH = 3;
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);
        if ($normalized === '') {
            throw InvalidHuespedException::becauseValueIsEmpty();
        }
        if (strlen($normalized) < self::MIN_LENGTH) {
            throw InvalidHuespedException::becauseLengthIsTooShort(self::MIN_LENGTH);
        }
        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(NombreHuesped $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}