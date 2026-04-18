<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/CreateReservaUseCase.php';
require_once __DIR__ . '/../Ports/Out/SaveReservaPort.php';
require_once __DIR__ . '/Mappers/ReservaApplicationMapper.php';
final class CreateReservaService implements CreateReservaUseCase
{
    private SaveReservaPort $saveReservaPort;

    public function __construct(SaveReservaPort $saveReservaPort)
    {
        $this->saveReservaPort = $saveReservaPort;
    }

    public function execute(CreateReservaCommand $command): ReservaHotelModel
    {
        $reserva = ReservaApplicationMapper::fromCreateCommandToModel($command);
        return $this->saveReservaPort->save($reserva);
    }
}