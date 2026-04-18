<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/UpdateReservaUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateReservaPort.php';
require_once __DIR__ . '/../Ports/Out/GetReservaByIdPort.php';
require_once __DIR__ . '/Mappers/ReservaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/ReservaNotFoundException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/ReservaId.php';
final class UpdateReservaService implements UpdateReservaUseCase
{
    private UpdateReservaPort $updateReservaPort;
    private GetReservaByIdPort $getReservaByIdPort;

    public function __construct(
        UpdateReservaPort $updateReservaPort,
        GetReservaByIdPort $getReservaByIdPort
    ) {
        $this->updateReservaPort = $updateReservaPort;
        $this->getReservaByIdPort = $getReservaByIdPort;
    }

    public function execute(UpdateReservaCommand $command): ReservaHotelModel
    {
        $reservaId = new ReservaId($command->getId());
        $currentReserva = $this->getReservaByIdPort->getById($reservaId);

        if ($currentReserva === null) {
            throw ReservaNotFoundException::becauseIdWasNotFound($reservaId->value());
        }

        $reservaToUpdate = ReservaApplicationMapper::fromUpdateCommandToModel($command, $currentReserva);

        return $this->updateReservaPort->update($reservaToUpdate);
    }
}