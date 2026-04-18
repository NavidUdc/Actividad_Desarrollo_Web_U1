<?php
require_once __DIR__ . '/../Exceptions/InvalidEstadoReservaException.php';
class EstadoReservaEnum
{
    public const PENDIENTE = 'PENDIENTE';
    public const CONFIRMADA = 'CONFIRMADA';
    public const CHECKIN = 'CHECKIN';
    public const CHECKOUT = 'CHECKOUT';
    public const CANCELADA = 'CANCELADA';

    public static function values(): array
    {
        return [
            self::PENDIENTE,
            self::CONFIRMADA,
            self::CHECKIN,
            self::CHECKOUT,
            self::CANCELADA
        ];
    }

    public static function isValid(string $value): bool
    {
        return in_array($value, self::values(), true);
    }

    public static function ensureIsValid(string $value): void
    {
        if (!self::isValid($value)) {
            throw InvalidEstadoReservaException::becauseValueIsInvalid($value);
        }
    }
}
