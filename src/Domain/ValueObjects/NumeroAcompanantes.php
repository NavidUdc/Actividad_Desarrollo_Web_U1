<?php
declare(strict_types=1);
require_once __DIR__ . "/../Exceptions/InvalidNumerosAcompanantesException.php";
class NumeroAcompanantes
{
    private int $value;

    public function __construct($value)
    {
        if (is_string($value)) {
            $normalized = trim($value);
            if ($normalized === '') {
                $this->value = 0;
                return;
            }
            if (!is_numeric($normalized)) {
                throw InvalidNumerosAcompanantesException::becauseValueIsNotNumeric($normalized);
            }
            $intValue = (int) $normalized;
        } elseif (is_numeric($value)) {
            $intValue = (int) $value;
        } else {
            $this->value = 0;
            return;
        }

        if ($intValue < 0) {
            throw InvalidNumerosAcompanantesException::becauseValueIsNegative($intValue);
        }

        $this->value = $intValue;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(NumeroAcompanantes $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}