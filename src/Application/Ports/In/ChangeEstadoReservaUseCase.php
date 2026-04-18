<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/ChangeEstadoReservaCommand.php';
require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface ChangeEstadoReservaUseCase
{
    public function execute(ChangeEstadoReservaCommand $command): ReservaHotelModel;
}