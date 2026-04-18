<?php
declare(strict_types=1);
class DescripcionReserva
{
    private ?string $value;

    public function __construct(?string $value = null)
    {
        if ($value === null || trim($value) === '') {
            $this->value = null;
        } else {
            $this->value = trim($value);
        }
    }

    public function value(): ?string
    {
        return $this->value;
    }

    public function equals(DescripcionReserva $other): bool
    {
        return $this->value === $other->value();
    }

    public function __toString(): string
    {
        return $this->value ?? '';
    }
}