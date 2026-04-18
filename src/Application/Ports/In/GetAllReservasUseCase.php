<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetAllReservasQuery.php';
require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface GetAllReservasUseCase
{
    /**
     * @return ReservaHotelModel[]
     */
    public function execute(GetAllReservasQuery $query): array;
}