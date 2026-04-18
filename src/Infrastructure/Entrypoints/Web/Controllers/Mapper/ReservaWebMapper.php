<?php
declare(strict_types=1);

require_once __DIR__ . '/../Dto/CreateReservaWebRequest.php';
require_once __DIR__ . '/../Dto/UpdateReservaWebRequest.php';
require_once __DIR__ . '/../Dto/ReservaResponse.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/CreateReservaCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/UpdateReservaCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/DeleteReservaCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Commands/ChangeEstadoReservaCommand.php';
require_once __DIR__ . '/../../../../../Application/Services/Dto/Queries/GetReservaByIdQuery.php';
require_once __DIR__ . '/../../../../../Domain/Models/ReservaHotelModel.php';
final class ReservaWebMapper
{
    public function fromCreateRequestToCommand(CreateReservaWebRequest $request): CreateReservaCommand
    {
        return new CreateReservaCommand(
            $request->getId(),
            $request->getFecha(),
            $request->getHotel(),
            $request->getHuesped(),
            $request->getFechaInicio(),
            $request->getFechaFin(),
            $request->getValor(),
            $request->getHabitacion(),
            $request->getNumAcompanantes(),
            $request->getPais(),
            $request->getDepartamento(),
            $request->getCiudad(),
            $request->getHoraCheckin(),
            $request->getHoraCheckout(),
            $request->getEmpleadoAtiende(),
            $request->getEmpleadoDespide(),
            $request->getDescripcion()
        );
    }

    public function fromUpdateRequestToCommand(UpdateReservaWebRequest $request): UpdateReservaCommand
    {
        return new UpdateReservaCommand(
            $request->getId(),
            $request->getFecha(),
            $request->getHotel(),
            $request->getHuesped(),
            $request->getFechaInicio(),
            $request->getFechaFin(),
            $request->getValor(),
            $request->getHabitacion(),
            $request->getNumAcompanantes(),
            $request->getPais(),
            $request->getDepartamento(),
            $request->getCiudad(),
            $request->getHoraCheckin(),
            $request->getHoraCheckout(),
            $request->getEmpleadoAtiende(),
            $request->getEmpleadoDespide(),
            $request->getDescripcion(),
            $request->getEstado()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetReservaByIdQuery
    {
        return new GetReservaByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeleteReservaCommand
    {
        return new DeleteReservaCommand($id);
    }

    public function fromIdAndEstadoToChangeEstadoCommand(string $id, string $estado): ChangeEstadoReservaCommand
    {
        return new ChangeEstadoReservaCommand($id, $estado);
    }

    public function fromModelToResponse(ReservaHotelModel $reserva): ReservaResponse
    {
        return new ReservaResponse(
            $reserva->id()->value(),
            $reserva->fecha()->format('Y-m-d'),
            $reserva->hotel()->value(),
            $reserva->huesped()->value(),
            $reserva->fechaInicio()->format('Y-m-d'),
            $reserva->fechaFin()->format('Y-m-d'),
            $reserva->valor()->value(),
            $reserva->habitacion()->value(),
            $reserva->numAcompanantes()->value(),
            $reserva->pais()->value(),
            $reserva->departamento()->value(),
            $reserva->ciudad()->value(),
            $reserva->horaCheckin()->format('H:i'),
            $reserva->horaCheckout()->format('H:i'),
            $reserva->empleadoAtiende()->value(),
            $reserva->empleadoDespide()->value(),
            $reserva->descripcion()->value(),
            $reserva->estado()
        );
    }

    /**
     * @param ReservaHotelModel[] $reservas
     * @return ReservaResponse[]
     */
    public function fromModelsToResponses(array $reservas): array
    {
        $responses = [];
        foreach ($reservas as $reserva) {
            $responses[] = $this->fromModelToResponse($reserva);
        }
        return $responses;
    }
}