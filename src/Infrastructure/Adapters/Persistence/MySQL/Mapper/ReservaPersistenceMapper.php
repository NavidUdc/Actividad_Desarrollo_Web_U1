<?php

declare(strict_types=1);

require_once __DIR__ . '/../Dto/ReservaPersistenceDto.php';
require_once __DIR__ . '/../Entity/ReservaEntity.php';
require_once __DIR__ . '/../../../../../Domain/Models/ReservaHotelModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/ReservaId.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/FechaReserva.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/NombreHotel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/NombreHuesped.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/FechaInicio.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/FechaFin.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/ValorReserva.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/NumeroHabitacion.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/NumeroAcompanantes.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/Pais.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/Departamento.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/Ciudad.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/HoraCheckin.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/HoraCheckout.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/NombreEmpleado.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/DescripcionReserva.php';

class ReservaPersistenceMapper
{
    public function fromModelToDto(ReservaHotelModel $reserva): ReservaPersistenceDto
    {
        return new ReservaPersistenceDto(
            $reserva->id()->value(),
            $reserva->fecha()->format(),
            $reserva->hotel()->value(),
            $reserva->huesped()->value(),
            $reserva->fechaInicio()->format(),
            $reserva->fechaFin()->format(),
            $reserva->valor()->value(),
            $reserva->habitacion()->value(),
            $reserva->numAcompanantes()->value(),
            $reserva->pais()->value(),
            $reserva->departamento()->value(),
            $reserva->ciudad()->value(),
            $reserva->horaCheckin()->format(),
            $reserva->horaCheckout()->format(),
            $reserva->empleadoAtiende()->value(),
            $reserva->empleadoDespide()->value(),
            $reserva->descripcion()->value(),
            $reserva->estado()
        );
    }

    public function fromRowToEntity(array $row): ReservaEntity
    {
        return new ReservaEntity(
            (string)$row['id'],
            (string)$row['fecha'],
            (string)$row['hotel'],
            (string)$row['huesped'],
            (string)$row['fecha_inicio'],
            (string)$row['fecha_fin'],
            (float)$row['valor'],
            (string)$row['habitacion'],
            (int)$row['num_acompanantes'],
            (string)$row['pais'],
            (string)$row['departamento'],
            (string)$row['ciudad'],
            (string)$row['hora_checkin'],
            (string)$row['hora_checkout'],
            (string)$row['empleado_atiende'],
            (string)$row['empleado_despide'],
            isset($row['descripcion']) ? (string)$row['descripcion'] : null,
            (string)$row['estado'],
            isset($row['created_at']) ? (string)$row['created_at'] : null,
            isset($row['updated_at']) ? (string)$row['updated_at'] : null
        );
    }

    public function fromEntityToModel(ReservaEntity $entity): ReservaHotelModel
    {
        return new ReservaHotelModel(
            new ReservaId($entity->id()),
            new FechaReserva($entity->fecha()),
            new NombreHotel($entity->hotel()),
            new NombreHuesped($entity->huesped()),
            new FechaInicio($entity->fechaInicio()),
            new FechaFin($entity->fechaFin()),
            new ValorReserva($entity->valor()),
            new NumeroHabitacion($entity->habitacion()),
            new NumeroAcompanantes($entity->numAcompanantes()),
            new Pais($entity->pais()),
            new Departamento($entity->departamento()),
            new Ciudad($entity->ciudad()),
            new HoraCheckin($entity->horaCheckin()),
            new HoraCheckout($entity->horaCheckout()),
            new NombreEmpleado($entity->empleadoAtiende()),
            new NombreEmpleado($entity->empleadoDespide()),
            new DescripcionReserva($entity->descripcion()),
            $entity->estado()
        );
    }

    public function fromRowToModel(array $row): ReservaHotelModel
    {
        return $this->fromEntityToModel($this->fromRowToEntity($row));
    }

    public function fromRowsToModels(array $rows): array
    {
        $models = [];
        foreach ($rows as $row) {
            $models[] = $this->fromRowToModel($row);
        }
        return $models;
    }
}