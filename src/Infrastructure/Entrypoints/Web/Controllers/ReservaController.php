<?php
declare(strict_types=1);

require_once __DIR__ . '/Mapper/ReservaWebMapper.php';
require_once __DIR__ . '/../../../../Application/Ports/In/CreateReservaUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/UpdateReservaUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/DeleteReservaUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetReservaByIdUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/GetAllReservasUseCase.php';
require_once __DIR__ . '/../../../../Application/Ports/In/ChangeEstadoReservaUseCase.php';
require_once __DIR__ . '/../../../../Application/Services/Dto/Queries/GetAllReservasQuery.php';
final class ReservaController
{
    private CreateReservaUseCase $createReservaUseCase;
    private UpdateReservaUseCase $updateReservaUseCase;
    private DeleteReservaUseCase $deleteReservaUseCase;
    private GetReservaByIdUseCase $getReservaByIdUseCase;
    private GetAllReservasUseCase $getAllReservasUseCase;
    private ChangeEstadoReservaUseCase $changeEstadoReservaUseCase;
    private ReservaWebMapper $mapper;

    public function __construct(
        CreateReservaUseCase $createReservaUseCase,
        UpdateReservaUseCase $updateReservaUseCase,
        DeleteReservaUseCase $deleteReservaUseCase,
        GetReservaByIdUseCase $getReservaByIdUseCase,
        GetAllReservasUseCase $getAllReservasUseCase,
        ChangeEstadoReservaUseCase $changeEstadoReservaUseCase,
        ReservaWebMapper $mapper
    ) {
        $this->createReservaUseCase = $createReservaUseCase;
        $this->updateReservaUseCase = $updateReservaUseCase;
        $this->deleteReservaUseCase = $deleteReservaUseCase;
        $this->getReservaByIdUseCase = $getReservaByIdUseCase;
        $this->getAllReservasUseCase = $getAllReservasUseCase;
        $this->changeEstadoReservaUseCase = $changeEstadoReservaUseCase;
        $this->mapper = $mapper;
    }

    /**
     * @return ReservaResponse[]
     */
    public function index(): array
    {
        $reservas = $this->getAllReservasUseCase->execute(new GetAllReservasQuery());
        return $this->mapper->fromModelsToResponses($reservas);
    }

    public function show(string $id): ReservaResponse
    {
        $query = $this->mapper->fromIdToGetByIdQuery($id);
        $reserva = $this->getReservaByIdUseCase->execute($query);
        return $this->mapper->fromModelToResponse($reserva);
    }

    public function store(CreateReservaWebRequest $request): ReservaResponse
    {
        $command = $this->mapper->fromCreateRequestToCommand($request);
        $reserva = $this->createReservaUseCase->execute($command);
        return $this->mapper->fromModelToResponse($reserva);
    }

    public function update(UpdateReservaWebRequest $request): ReservaResponse
    {
        $command = $this->mapper->fromUpdateRequestToCommand($request);
        $reserva = $this->updateReservaUseCase->execute($command);
        return $this->mapper->fromModelToResponse($reserva);
    }

    public function delete(string $id): void
    {
        $command = $this->mapper->fromIdToDeleteCommand($id);
        $this->deleteReservaUseCase->execute($command);
    }

    public function changeEstado(string $id, string $estado): ReservaResponse
    {
        $command = $this->mapper->fromIdAndEstadoToChangeEstadoCommand($id, $estado);
        $reserva = $this->changeEstadoReservaUseCase->execute($command);
        return $this->mapper->fromModelToResponse($reserva);
    }
}