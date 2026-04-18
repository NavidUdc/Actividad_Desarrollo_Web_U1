<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetReservaByIdUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetReservaByIdPort.php';
require_once __DIR__ . '/Mappers/ReservaApplicationMapper.php';
require_once __DIR__ . '/../../Domain/Exceptions/ReservaNotFoundException.php';
final class GetReservaByIdService implements GetReservaByIdUseCase
{
    private GetReservaByIdPort $getReservaByIdPort;

    public function __construct(GetReservaByIdPort $getReservaByIdPort)
    {
        $this->getReservaByIdPort = $getReservaByIdPort;
    }

    public function execute(GetReservaByIdQuery $query): ReservaHotelModel
    {
        $reservaId = ReservaApplicationMapper::fromGetReservaByIdQueryToReservaId($query);
        $reserva = $this->getReservaByIdPort->getById($reservaId);

        if ($reserva === null) {
            throw ReservaNotFoundException::becauseIdWasNotFound($reservaId->value());
        }

        return $reserva;
    }
}