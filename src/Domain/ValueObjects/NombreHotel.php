<?php
declare(strict_types=1);
require_once __DIR__ . "/../Exceptions/InvalidNombreHotelException.php";
class NombreHotel
{
    private const MIN_LENGTH = 3;
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);
        if ($normalized === '') {
            throw InvalidNombreHotelException::becauseValueIsEmpty();
        }
        if (strlen($normalized) < self::MIN_LENGTH) {
            throw InvalidNombreHotelException::becauseLengthIsTooShort(self::MIN_LENGTH);
        }
        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(NombreHotel $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}