<?php
declare(strict_types=1);
final class UpdateReservaWebRequest
{
    private string $id;
    private string $fecha;
    private string $hotel;
    private string $huesped;
    private string $fechaInicio;
    private string $fechaFin;
    private string $valor;
    private string $habitacion;
    private string $numAcompanantes;
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
        string $valor,
        string $habitacion,
        string $numAcompanantes,
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
        $this->id = trim($id);
        $this->fecha = trim($fecha);
        $this->hotel = trim($hotel);
        $this->huesped = trim($huesped);
        $this->fechaInicio = trim($fechaInicio);
        $this->fechaFin = trim($fechaFin);
        $this->valor = trim($valor);
        $this->habitacion = trim($habitacion);
        $this->numAcompanantes = trim($numAcompanantes);
        $this->pais = trim($pais);
        $this->departamento = trim($departamento);
        $this->ciudad = trim($ciudad);
        $this->horaCheckin = trim($horaCheckin);
        $this->horaCheckout = trim($horaCheckout);
        $this->empleadoAtiende = trim($empleadoAtiende);
        $this->empleadoDespide = trim($empleadoDespide);
        $this->descripcion = $descripcion !== null ? trim($descripcion) : null;
        $this->estado = trim($estado);
    }

    public function getId(): string { return $this->id; }
    public function getFecha(): string { return $this->fecha; }
    public function getHotel(): string { return $this->hotel; }
    public function getHuesped(): string { return $this->huesped; }
    public function getFechaInicio(): string { return $this->fechaInicio; }
    public function getFechaFin(): string { return $this->fechaFin; }
    public function getValor(): string { return $this->valor; }
    public function getHabitacion(): string { return $this->habitacion; }
    public function getNumAcompanantes(): string { return $this->numAcompanantes; }
    public function getPais(): string { return $this->pais; }
    public function getDepartamento(): string { return $this->departamento; }
    public function getCiudad(): string { return $this->ciudad; }
    public function getHoraCheckin(): string { return $this->horaCheckin; }
    public function getHoraCheckout(): string { return $this->horaCheckout; }
    public function getEmpleadoAtiende(): string { return $this->empleadoAtiende; }
    public function getEmpleadoDespide(): string { return $this->empleadoDespide; }
    public function getDescripcion(): ?string { return $this->descripcion; }
    public function getEstado(): string { return $this->estado; }
}