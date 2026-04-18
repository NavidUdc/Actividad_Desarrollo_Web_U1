<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Queries/GetReservaByIdQuery.php';
require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
interface GetReservaByIdUseCase
{
    public function execute(GetReservaByIdQuery $query): ReservaHotelModel;
}