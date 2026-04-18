<?php
declare(strict_types=1);
final class ChangeEstadoReservaCommand
{
    private string $id;
    private string $estado;

    public function __construct(string $id, string $estado)
    {
        $this->id = trim($id);
        $this->estado = trim($estado);
    }

    public function getId(): string { return $this->id; }
    public function getEstado(): string { return $this->estado; }
}