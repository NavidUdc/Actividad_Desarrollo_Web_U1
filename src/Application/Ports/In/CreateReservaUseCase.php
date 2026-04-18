<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/CreateReservaCommand.php';
require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface CreateReservaUseCase
{
    public function execute(CreateReservaCommand $command): ReservaHotelModel;

}