<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface UpdateReservaPort
{
    public function update(ReservaHotelModel $reserva): ReservaHotelModel;
}