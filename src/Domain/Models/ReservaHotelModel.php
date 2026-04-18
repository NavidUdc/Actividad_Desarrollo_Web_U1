<?php
declare(strict_types=1);

require_once __DIR__ . "/../ValueObjects/FechaReserva.php";
require_once __DIR__ . "/../ValueObjects/DescripcionReserva.php";
require_once __DIR__ . "/../ValueObjects/ReservaId.php";
require_once __DIR__ . "/../ValueObjects/ValorReserva.php";
require_once __DIR__ . "/../ValueObjects/HoraCheckin.php";
require_once __DIR__ . "/../ValueObjects/HoraCheckout.php";
require_once __DIR__ . "/../ValueObjects/Ciudad.php";
require_once __DIR__ . "/../ValueObjects/Pais.php";
require_once __DIR__ . "/../ValueObjects/Departamento.php";
require_once __DIR__ . "/../ValueObjects/FechaFin.php";
require_once __DIR__ . "/../ValueObjects/NombreHotel.php";
require_once __DIR__ . "/../ValueObjects/NombreHuesped.php";
require_once __DIR__ . "/../ValueObjects/NombreEmpleado.php";
require_once __DIR__ . "/../ValueObjects/NumeroAcompanantes.php";
require_once __DIR__ . "/../ValueObjects/NumeroHabitacion.php";
require_once __DIR__ . "/../ValueObjects/FechaInicio.php";

require_once __DIR__ . "/../Enums/EstadoReservaEnum.php";
class ReservaHotelModel
{
    private ReservaId $id;
    private FechaReserva $fecha;
    private NombreHotel $hotel;
    private NombreHuesped $huesped;
    private FechaInicio $fechaInicio;
    private FechaFin $fechaFin;
    private ValorReserva $valor;
    private NumeroHabitacion $habitacion;
    private NumeroAcompanantes $numAcompanantes;
    private Pais $pais;
    private Departamento $departamento;
    private Ciudad $ciudad;
    private HoraCheckin $horaCheckin;
    private HoraCheckout $horaCheckout;
    private NombreEmpleado $empleadoAtiende;
    private NombreEmpleado $empleadoDespide;
    private DescripcionReserva $descripcion;
    private string $estado;

    public function __construct(
        ReservaId          $id,
        FechaReserva       $fecha,
        NombreHotel        $hotel,
        NombreHuesped      $huesped,
        FechaInicio        $fechaInicio,
        FechaFin           $fechaFin,
        ValorReserva       $valor,
        NumeroHabitacion   $habitacion,
        NumeroAcompanantes $numAcompanantes,
        Pais               $pais,
        Departamento       $departamento,
        Ciudad             $ciudad,
        HoraCheckin        $horaCheckin,
        HoraCheckout       $horaCheckout,
        NombreEmpleado     $empleadoAtiende,
        NombreEmpleado     $empleadoDespide,
        DescripcionReserva $descripcion,
        string             $estado
    ) {
        if ($fechaInicio->esMayorQue($fechaFin)) {
            throw InvalidFechasReservaException::becauseFechaInicioMayorQueFechaFin(
                $fechaInicio->format(),
                $fechaFin->format()
            );
        }

        EstadoReservaEnum::ensureIsValid($estado);

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

    public static function create(
        ReservaId $id,
        FechaReserva $fecha,
        NombreHotel $hotel,
        NombreHuesped $huesped,
        FechaInicio $fechaInicio,
        FechaFin $fechaFin,
        ValorReserva $valor,
        NumeroHabitacion $habitacion,
        NumeroAcompanantes $numAcompanantes,
        Pais $pais,
        Departamento $departamento,
        Ciudad $ciudad,
        HoraCheckin $horaCheckin,
        HoraCheckout $horaCheckout,
        NombreEmpleado $empleadoAtiende,
        NombreEmpleado $empleadoDespide,
        DescripcionReserva $descripcion
    ): self {
        return new self(
            $id,
            $fecha,
            $hotel,
            $huesped,
            $fechaInicio,
            $fechaFin,
            $valor,
            $habitacion,
            $numAcompanantes,
            $pais,
            $departamento,
            $ciudad,
            $horaCheckin,
            $horaCheckout,
            $empleadoAtiende,
            $empleadoDespide,
            $descripcion,
            EstadoReservaEnum::PENDIENTE
        );
    }

    // Getters
    public function id(): ReservaId { return $this->id; }
    public function fecha(): FechaReserva { return $this->fecha; }
    public function hotel(): NombreHotel { return $this->hotel; }
    public function huesped(): NombreHuesped { return $this->huesped; }
    public function fechaInicio(): FechaInicio { return $this->fechaInicio; }
    public function fechaFin(): FechaFin { return $this->fechaFin; }
    public function valor(): ValorReserva { return $this->valor; }
    public function habitacion(): NumeroHabitacion { return $this->habitacion; }
    public function numAcompanantes(): NumeroAcompanantes { return $this->numAcompanantes; }
    public function pais(): Pais { return $this->pais; }
    public function departamento(): Departamento { return $this->departamento; }
    public function ciudad(): Ciudad { return $this->ciudad; }
    public function horaCheckin(): HoraCheckin { return $this->horaCheckin; }
    public function horaCheckout(): HoraCheckout { return $this->horaCheckout; }
    public function empleadoAtiende(): NombreEmpleado { return $this->empleadoAtiende; }
    public function empleadoDespide(): NombreEmpleado { return $this->empleadoDespide; }
    public function descripcion(): DescripcionReserva { return $this->descripcion; }
    public function estado(): string { return $this->estado; }

    // Métodos de cambio de estado (inmutables)
    public function confirmar(): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion,
            EstadoReservaEnum::CONFIRMADA
        );
    }

    public function hacerCheckin(): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion,
            EstadoReservaEnum::CHECKIN
        );
    }

    public function hacerCheckout(): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion,
            EstadoReservaEnum::CHECKOUT
        );
    }

    public function cancelar(): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion,
            EstadoReservaEnum::CANCELADA
        );
    }

    // Métodos de actualización
    public function cambiarHotel(NombreHotel $hotel): self
    {
        return new self(
            $this->id, $this->fecha, $hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarHuesped(NombreHuesped $huesped): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarFechas(FechaInicio $fechaInicio, FechaFin $fechaFin): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $fechaInicio, $fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarValor(ValorReserva $valor): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarHabitacion(NumeroHabitacion $habitacion): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarAcompanantes(NumeroAcompanantes $num): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $num,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarUbicacion(Pais $pais, Departamento $departamento, Ciudad $ciudad): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $pais, $departamento, $ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarHoras(HoraCheckin $checkin, HoraCheckout $checkout): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $checkin, $checkout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarEmpleados(NombreEmpleado $atiende, NombreEmpleado $despide): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $atiende, $despide,
            $this->descripcion, $this->estado
        );
    }

    public function cambiarDescripcion(DescripcionReserva $descripcion): self
    {
        return new self(
            $this->id, $this->fecha, $this->hotel, $this->huesped,
            $this->fechaInicio, $this->fechaFin, $this->valor,
            $this->habitacion, $this->numAcompanantes,
            $this->pais, $this->departamento, $this->ciudad,
            $this->horaCheckin, $this->horaCheckout,
            $this->empleadoAtiende, $this->empleadoDespide,
            $descripcion, $this->estado
        );
    }
}