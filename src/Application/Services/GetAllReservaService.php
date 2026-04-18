<?php
declare(strict_types=1);

require_once __DIR__ . '/../Ports/In/GetAllReservasUseCase.php';
require_once __DIR__ . '/../Ports/Out/GetAllReservasPort.php';
final class GetAllReservaService implements GetAllReservasUseCase
{
    private GetAllReservasPort $getAllReservasPort;

    public function __construct(GetAllReservasPort $getAllReservasPort)
    {
        $this->getAllReservasPort = $getAllReservasPort;
    }

    /**
     * @return ReservaHotelModel[]
     */
    public function execute(GetAllReservasQuery $query): array
    {
        return $this->getAllReservasPort->getAll();
    }
}