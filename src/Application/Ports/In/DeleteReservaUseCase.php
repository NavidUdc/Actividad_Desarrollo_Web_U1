<?php
declare(strict_types=1);

require_once __DIR__ . '/../../Services/Dto/Commands/DeleteReservaCommand.php';
interface DeleteReservaUseCase
{
    public function execute(DeleteReservaCommand $command): void;
}