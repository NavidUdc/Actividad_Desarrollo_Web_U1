<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../Domain/ValueObjects/ReservaId.php';
interface DeleteReservaPort
{
    public function delete(ReservaId $reservaId): void;
}