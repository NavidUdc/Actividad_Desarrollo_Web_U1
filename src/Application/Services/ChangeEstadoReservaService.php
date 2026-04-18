<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/ChangeEstadoReservaUseCase.php';
require_once __DIR__ . '/../Ports/Out/UpdateReservaPort.php';
require_once __DIR__ . '/../Ports/Out/GetReservaByIdPort.php';
require_once __DIR__ . '/../../Domain/Exceptions/ReservaNotFoundException.php';
require_once __DIR__ . '/../../Domain/ValueObjects/ReservaId.php';
final class ChangeEstadoReservaService implements ChangeEstadoReservaUseCase
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

    public function execute(ChangeEstadoReservaCommand $command): ReservaHotelModel
    {
        $reservaId = new ReservaId($command->getId());
        $reserva = $this->getReservaByIdPort->getById($reservaId);

        if ($reserva === null) {
            throw ReservaNotFoundException::becauseIdWasNotFound($reservaId->value());
        }

        $updatedReserva = match ($command->getEstado()) {
            'CONFIRMADA' => $reserva->confirmar(),
            'CHECKIN' => $reserva->hacerCheckin(),
            'CHECKOUT' => $reserva->hacerCheckout(),
            'CANCELADA' => $reserva->cancelar(),
            default => $reserva
        };

        return $this->updateReservaPort->update($updatedReserva);
    }
}