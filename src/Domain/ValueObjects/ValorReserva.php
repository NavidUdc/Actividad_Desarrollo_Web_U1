<?php
declare(strict_types=1);
require_once __DIR__ . '/../Exceptions/InvalidValorReservaException.php';
class ValorReserva
{
    private float $value;

    public function __construct($value)
    {
        if (is_string($value)) {
            $normalized = trim($value);
            if ($normalized === '') {
                throw InvalidValorReservaException::becauseValueIsEmpty();
            }
            if (!is_numeric($normalized)) {
                throw InvalidValorReservaException::becauseValueIsNotNumeric($normalized);
            }
            $floatValue = (float) $normalized;
        } elseif (is_numeric($value)) {
            $floatValue = (float) $value;
        } else {
            throw InvalidValorReservaException::becauseValueIsEmpty();
        }

        if ($floatValue <= 0) {
            throw InvalidValorReservaException::becauseValueIsZeroOrNegative($floatValue);
        }

        $this->value = $floatValue;
    }

    public function value(): float
    {
        return $this->value;
    }

    public function format(int $decimals = 2): string
    {
        return number_format($this->value, $decimals, '.', ',');
    }

    public function equals(ValorReserva $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}