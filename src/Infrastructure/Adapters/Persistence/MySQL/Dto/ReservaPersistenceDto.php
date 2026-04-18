<?php
declare(strict_types=1);
final class ReservaPersistenceDto
{
    private string $id;
    private string $fecha;
    private string $hotel;
    private string $huesped;
    private string $fechaInicio;
    private string $fechaFin;
    private float $valor;
    private string $habitacion;
    private int $numAcompanantes;
    private string $pais;
    private string $departamento;
    private string $ciudad;
    private string $horaCheckin;
    private string $horaCheckout;
    private string $empleadoAtiende;
    private string $empleadoDespide;
    private ?string $descripcion;
    private string $estado;

    public function __construct(
        string $id,
        string $fecha,
        string $hotel,
        string $huesped,
        string $fechaInicio,
        string $fechaFin,
        float $valor,
        string $habitacion,
        int $numAcompanantes,
        string $pais,
        string $departamento,
        string $ciudad,
        string $horaCheckin,
        string $horaCheckout,
        string $empleadoAtiende,
        string $empleadoDespide,
        ?string $descripcion,
        string $estado
    ) {
        $this->id = $id;
        $this->fecha = $fecha;
        $this->hotel = $hotel;
        $this->huesped = $huesped;
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->valor = $valor;
        $this->habitacion = $habitacion;
        $this->numAcompanantes = $numAcompanantes;
        $this->pais = $pais;
        $this->departamento = $departamento;
        $this->ciudad = $ciudad;
        $this->horaCheckin = $horaCheckin;
        $this->horaCheckout = $horaCheckout;
        $this->empleadoAtiende = $empleadoAtiende;
        $this->empleadoDespide = $empleadoDespide;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
    }

    public function id(): string { return $this->id; }
    public function fecha(): string { return $this->fecha; }
    public function hotel(): string { return $this->hotel; }
    public function huesped(): string { return $this->huesped; }
    public function fechaInicio(): string { return $this->fechaInicio; }
    public function fechaFin(): string { return $this->fechaFin; }
    public function valor(): float { return $this->valor; }
    public function habitacion(): string { return $this->habitacion; }
    public function numAcompanantes(): int { return $this->numAcompanantes; }
    public function pais(): string { return $this->pais; }
    public function departamento(): string { return $this->departamento; }
    public function ciudad(): string { return $this->ciudad; }
    public function horaCheckin(): string { return $this->horaCheckin; }
    public function horaCheckout(): string { return $this->horaCheckout; }
    public function empleadoAtiende(): string { return $this->empleadoAtiende; }
    public function empleadoDespide(): string { return $this->empleadoDespide; }
    public function descripcion(): ?string { return $this->descripcion; }
    public function estado(): string { return $this->estado; }
}