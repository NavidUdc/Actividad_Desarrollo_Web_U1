<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../../../Application/Ports/Out/SaveReservaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/UpdateReservaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/DeleteReservaPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetReservaByIdPort.php';
require_once __DIR__ . '/../../../../../Application/Ports/Out/GetAllReservasPort.php';
require_once __DIR__ . '/../Mapper/ReservaPersistenceMapper.php';
require_once __DIR__ . '/../../../../../Domain/Models/ReservaHotelModel.php';
require_once __DIR__ . '/../../../../../Domain/ValueObjects/ReservaId.php';
final class ReservaRepositoryMySQL implements
    SaveReservaPort,
    UpdateReservaPort,
    DeleteReservaPort,
    GetReservaByIdPort,
    GetAllReservasPort
{
    private PDO $pdo;
    private ReservaPersistenceMapper $mapper;

    public function __construct(PDO $pdo, ReservaPersistenceMapper $mapper)
    {
        $this->pdo = $pdo;
        $this->mapper = $mapper;
    }

    public function save(ReservaHotelModel $reserva): ReservaHotelModel
    {
        $dto = $this->mapper->fromModelToDto($reserva);

        $sql = '
            INSERT INTO reservas (
                id, fecha, hotel, huesped, fecha_inicio, fecha_fin, valor, habitacion,
                num_acompanantes, pais, departamento, ciudad, hora_checkin, hora_checkout,
                empleado_atiende, empleado_despide, descripcion, estado, created_at, updated_at
            ) VALUES (
                :id, :fecha, :hotel, :huesped, :fecha_inicio, :fecha_fin, :valor, :habitacion,
                :num_acompanantes, :pais, :departamento, :ciudad, :hora_checkin, :hora_checkout,
                :empleado_atiende, :empleado_despide, :descripcion, :estado, NOW(), NOW()
            )
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':id' => $dto->id(),
            ':fecha' => $dto->fecha(),
            ':hotel' => $dto->hotel(),
            ':huesped' => $dto->huesped(),
            ':fecha_inicio' => $dto->fechaInicio(),
            ':fecha_fin' => $dto->fechaFin(),
            ':valor' => $dto->valor(),
            ':habitacion' => $dto->habitacion(),
            ':num_acompanantes' => $dto->numAcompanantes(),
            ':pais' => $dto->pais(),
            ':departamento' => $dto->departamento(),
            ':ciudad' => $dto->ciudad(),
            ':hora_checkin' => $dto->horaCheckin(),
            ':hora_checkout' => $dto->horaCheckout(),
            ':empleado_atiende' => $dto->empleadoAtiende(),
            ':empleado_despide' => $dto->empleadoDespide(),
            ':descripcion' => $dto->descripcion(),
            ':estado' => $dto->estado(),
        ]);

        $savedReserva = $this->getById(new ReservaId($dto->id()));

        if ($savedReserva === null) {
            throw new RuntimeException('The reserva could not be recovered after save.');
        }

        return $savedReserva;
    }

    public function update(ReservaHotelModel $reserva): ReservaHotelModel
    {
        $dto = $this->mapper->fromModelToDto($reserva);

        $sql = '
            UPDATE reservas SET
                fecha = :fecha,
                hotel = :hotel,
                huesped = :huesped,
                fecha_inicio = :fecha_inicio,
                fecha_fin = :fecha_fin,
                valor = :valor,
                habitacion = :habitacion,
                num_acompanantes = :num_acompanantes,
                pais = :pais,
                departamento = :departamento,
                ciudad = :ciudad,
                hora_checkin = :hora_checkin,
                hora_checkout = :hora_checkout,
                empleado_atiende = :empleado_atiende,
                empleado_despide = :empleado_despide,
                descripcion = :descripcion,
                estado = :estado,
                updated_at = NOW()
            WHERE id = :id
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            ':id' => $dto->id(),
            ':fecha' => $dto->fecha(),
            ':hotel' => $dto->hotel(),
            ':huesped' => $dto->huesped(),
            ':fecha_inicio' => $dto->fechaInicio(),
            ':fecha_fin' => $dto->fechaFin(),
            ':valor' => $dto->valor(),
            ':habitacion' => $dto->habitacion(),
            ':num_acompanantes' => $dto->numAcompanantes(),
            ':pais' => $dto->pais(),
            ':departamento' => $dto->departamento(),
            ':ciudad' => $dto->ciudad(),
            ':hora_checkin' => $dto->horaCheckin(),
            ':hora_checkout' => $dto->horaCheckout(),
            ':empleado_atiende' => $dto->empleadoAtiende(),
            ':empleado_despide' => $dto->empleadoDespide(),
            ':descripcion' => $dto->descripcion(),
            ':estado' => $dto->estado(),
        ]);

        $updatedReserva = $this->getById(new ReservaId($dto->id()));

        if ($updatedReserva === null) {
            throw new RuntimeException('The reserva could not be recovered after update.');
        }

        return $updatedReserva;
    }

    public function getById(ReservaId $reservaId): ?ReservaHotelModel
    {
        $sql = '
            SELECT
                id, fecha, hotel, huesped, fecha_inicio, fecha_fin, valor, habitacion,
                num_acompanantes, pais, departamento, ciudad, hora_checkin, hora_checkout,
                empleado_atiende, empleado_despide, descripcion, estado, created_at, updated_at
            FROM reservas
            WHERE id = :id
            LIMIT 1
        ';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $reservaId->value()]);

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        return $this->mapper->fromRowToModel($row);
    }

    public function getAll(): array
    {
        $sql = '
            SELECT
                id, fecha, hotel, huesped, fecha_inicio, fecha_fin, valor, habitacion,
                num_acompanantes, pais, departamento, ciudad, hora_checkin, hora_checkout,
                empleado_atiende, empleado_despide, descripcion, estado, created_at, updated_at
            FROM reservas
            ORDER BY fecha DESC, created_at DESC
        ';

        $statement = $this->pdo->query($sql);
        $rows = $statement->fetchAll();

        return $this->mapper->fromRowsToModels($rows);
    }

    public function delete(ReservaId $reservaId): void
    {
        $sql = 'DELETE FROM reservas WHERE id = :id';

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id' => $reservaId->value()]);
    }
}