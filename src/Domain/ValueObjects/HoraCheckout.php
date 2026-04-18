<?php
declare(strict_types=1);
require_once __DIR__ . "/../Exceptions/InvalidHoraCheckoutException.php";
class HoraCheckout
{
    private DateTime $value;

    public function __construct($value)
    {
        if ($value instanceof DateTime) {
            $this->value = clone $value;
        } elseif (is_string($value)) {
            $normalized = trim($value);
            if ($normalized === '') {
                throw InvalidHoraCheckoutException::becauseValueIsEmpty();
            }
            try {
                $this->value = new DateTime($normalized);
            } catch (Exception $e) {
                throw InvalidHoraCheckoutException::becauseFormatIsInvalid($normalized);
            }
        } else {
            throw InvalidHoraCheckoutException::becauseValueIsEmpty();
        }
    }

    public function value(): DateTime
    {
        return clone $this->value;
    }

    public function format(string $format = 'H:i:s'): string
    {
        return $this->value->format($format);
    }

    public function equals(HoraCheckout $other): bool
    {
        return $this->format() === $other->format();
    }

    public function __toString(): string
    {
        return $this->format('H:i');
    }
}