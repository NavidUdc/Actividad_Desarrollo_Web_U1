<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/DeleteReservaUseCase.php';
require_once __DIR__ . '/../Ports/Out/DeleteReservaPort.php';
require_once __DIR__ . '/../Ports/Out/GetReservaByIdPort.php';
require_once __DIR__ . '/Mappers/ReservaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/ReservaNotFoundException.php';

final class DeleteReservaService implements DeleteReservaUseCase
{
    private DeleteReservaPort $deleteReservaPort;
    private GetReservaByIdPort $getReservaByIdPort;

    public function __construct(
        DeleteReservaPort $deleteReservaPort,
        GetReservaByIdPort $getReservaByIdPort
    ) {
        $this->deleteReservaPort = $deleteReservaPort;
        $this->getReservaByIdPort = $getReservaByIdPort;
    }

    public function execute(DeleteReservaCommand $command): void
    {
        $reservaId = ReservaApplicationMapper::fromDeleteCommandToReservaId($command);

        $existingReserva = $this->getReservaByIdPort->getById($reservaId);

        if ($existingReserva === null) {
            throw ReservaNotFoundException::becauseIdWasNotFound($reservaId->value());
        }

        $this->deleteReservaPort->delete($reservaId);
    }
}