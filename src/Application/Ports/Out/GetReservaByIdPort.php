<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/ReservaId.php';
interface GetReservaByIdPort
{
    public function getById(ReservaId $reservaId): ?ReservaHotelModel;
}