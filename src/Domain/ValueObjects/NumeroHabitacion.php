<?php
declare(strict_types=1);
class NumeroHabitacion
{
    private string $value;

    public function __construct(string $value)
    {
        $normalized = trim($value);
        if ($normalized === '') {
            $normalized = 'N/A';
        }
        $this->value = $normalized;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(NumeroHabitacion $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value;
    }
}