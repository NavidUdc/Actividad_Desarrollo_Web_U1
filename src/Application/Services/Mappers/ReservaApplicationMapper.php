<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dto/Commands/CreateReservaCommand.php';
require_once __DIR__ . '/../Dto/Commands/UpdateReservaCommand.php';
require_once __DIR__ . '/../Dto/Commands/DeleteReservaCommand.php';
require_once __DIR__ . '/../Dto/Commands/ChangeEstadoReservaCommand.php';
require_once __DIR__ . '/../Dto/Queries/GetReservaByIdQuery.php';

require_once __DIR__ . '/../../../Domain/Models/ReservaHotelModel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/ReservaId.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/FechaReserva.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/NombreHotel.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/NombreHuesped.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/FechaInicio.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/FechaFin.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/ValorReserva.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/NumeroHabitacion.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/NumeroAcompanantes.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/Pais.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/Departamento.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/Ciudad.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/HoraCheckin.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/HoraCheckout.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/NombreEmpleado.php';
require_once __DIR__ . '/../../../Domain/ValueObjects/DescripcionReserva.php';
final class ReservaApplicationMapper
{
    public static function fromCreateCommandToModel(CreateReservaCommand $command): ReservaHotelModel
    {
        return ReservaHotelModel::create(
            new ReservaId($command->getId()),
            new FechaReserva($command->getFecha()),
            new NombreHotel($command->getHotel()),
            new NombreHuesped($command->getHuesped()),
            new FechaInicio($command->getFechaInicio()),
            new FechaFin($command->getFechaFin()),
            new ValorReserva($command->getValor()),
            new NumeroHabitacion($command->getHabitacion()),
            new NumeroAcompanantes($command->getNumAcompanantes()),
            new Pais($command->getPais()),
            new Departamento($command->getDepartamento()),
            new Ciudad($command->getCiudad()),
            new HoraCheckin($command->getHoraCheckin()),
            new HoraCheckout($command->getHoraCheckout()),
            new NombreEmpleado($command->getEmpleadoAtiende()),
            new NombreEmpleado($command->getEmpleadoDespide()),
            new DescripcionReserva($command->getDescripcion())
        );
    }

    public static function fromUpdateCommandToModel(UpdateReservaCommand $command, ReservaHotelModel $current): ReservaHotelModel
    {
        return new ReservaHotelModel(
            new ReservaId($command->getId()),
            new FechaReserva($command->getFecha()),
            new NombreHotel($command->getHotel()),
            new NombreHuesped($command->getHuesped()),
            new FechaInicio($command->getFechaInicio()),
            new FechaFin($command->getFechaFin()),
            new ValorReserva($command->getValor()),
            new NumeroHabitacion($command->getHabitacion()),
            new NumeroAcompanantes($command->getNumAcompanantes()),
            new Pais($command->getPais()),
            new Departamento($command->getDepartamento()),
            new Ciudad($command->getCiudad()),
            new HoraCheckin($command->getHoraCheckin()),
            new HoraCheckout($command->getHoraCheckout()),
            new NombreEmpleado($command->getEmpleadoAtiende()),
            new NombreEmpleado($command->getEmpleadoDespide()),
            new DescripcionReserva($command->getDescripcion()),
            $command->getEstado()
        );
    }

    public static function fromGetReservaByIdQueryToReservaId(GetReservaByIdQuery $query): ReservaId
    {
        return new ReservaId($query->getId());
    }

    public static function fromDeleteCommandToReservaId(DeleteReservaCommand $command): ReservaId
    {
        return new ReservaId($command->getId());
    }

    public static function fromModelToArray(ReservaHotelModel $reserva): array
    {
        return [
            'id' => $reserva->id()->value(),
            'fecha' => $reserva->fecha()->format(),
            'hotel' => $reserva->hotel()->value(),
            'huesped' => $reserva->huesped()->value(),
            'fecha_inicio' => $reserva->fechaInicio()->format(),
            'fecha_fin' => $reserva->fechaFin()->format(),
            'valor' => $reserva->valor()->value(),
            'habitacion' => $reserva->habitacion()->value(),
            'num_acompanantes' => $reserva->numAcompanantes()->value(),
            'pais' => $reserva->pais()->value(),
            'departamento' => $reserva->departamento()->value(),
            'ciudad' => $reserva->ciudad()->value(),
            'hora_checkin' => $reserva->horaCheckin()->format(),
            'hora_checkout' => $reserva->horaCheckout()->format(),
            'empleado_atiende' => $reserva->empleadoAtiende()->value(),
            'empleado_despide' => $reserva->empleadoDespide()->value(),
            'descripcion' => $reserva->descripcion()->value(),
            'estado' => $reserva->estado(),
        ];
    }

    /**
     * @param ReservaHotelModel[] $reservas
     */
    public static function fromModelsToArray(array $reservas): array
    {
        $result = [];
        foreach ($reservas as $reserva) {
            $result[] = self::fromModelToArray($reserva);
        }
        return $result;
    }
}