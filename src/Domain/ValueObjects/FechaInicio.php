<?php
declare(strict_types=1);
require_once __DIR__ . '/../Exceptions/InvalidFechasReservaException.php';
require_once __DIR__ . '/FechaFin.php';
class FechaInicio
{
    private DateTime $value;

    public function __construct($value)
    {
        if ($value instanceof DateTime) {
            $this->value = clone $value;
            $this->value->setTime(0, 0, 0);
        } elseif (is_string($value)) {
            $normalized = trim($value);
            if ($normalized === '') {
                throw InvalidFechasReservaException::becauseValueIsEmpty();
            }
            try {
                $this->value = new DateTime($normalized);
                $this->value->setTime(0, 0, 0);
            } catch (Exception $e) {
                throw InvalidFechasReservaException::becauseFormatIsInvalid($normalized);
            }
        } else {
            throw InvalidFechasReservaException::becauseValueIsEmpty();
        }

        $hoy = new DateTime('today');
        if ($this->value < $hoy) {
            throw InvalidFechasReservaException::becauseStartDateIsLowerThanToday($this->format());
        }
    }

    public function value(): DateTime
    {
        return clone $this->value;
    }

    public function format(string $format = 'Y-m-d'): string
    {
        return $this->value->format($format);
    }

    public function esMayorQue(FechaFin $fechaFin): bool
    {
        return $this->value > $fechaFin->value();
    }

    public function equals(FechaInicio $other): bool
    {
        return $this->format() === $other->format();
    }

    public function __toString(): string
    {
        return $this->format();
    }
}