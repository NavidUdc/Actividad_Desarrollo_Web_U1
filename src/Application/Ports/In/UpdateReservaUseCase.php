<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/UpdateReservaCommand.php';
require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface UpdateReservaUseCase
{
    public function execute(UpdateReservaCommand $command): ReservaHotelModel;
}