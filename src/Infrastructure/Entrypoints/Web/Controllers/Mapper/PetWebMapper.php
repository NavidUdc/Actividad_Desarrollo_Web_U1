<?php

declare(strict_types=1);

final class PetWebMapper
{
    public function fromCreateRequestToCommand(CreatePetWebRequest $request): CreatePetCommand
    {
        return new CreatePetCommand(
            $request->getId(),
            $request->getName(),
            $request->getGender(),
            $request->getWeight(),
            $request->getSize(),
            $request->getColor(),
            $request->getBreed(),
            $request->getSpecies(),
            $request->getBirthDate(),
            $request->getOwner(),
            $request->getHabitat(),
            $request->getHasVaccines(),
            $request->getVeterinarian()
        );
    }

    public function fromUpdateRequestToCommand(UpdatePetWebRequest $request): UpdatePetCommand
    {
        return new UpdatePetCommand(
            $request->getId(),
            $request->getName(),
            $request->getGender(),
            $request->getWeight(),
            $request->getSize(),
            $request->getColor(),
            $request->getBreed(),
            $request->getSpecies(),
            $request->getBirthDate(),
            $request->getOwner(),
            $request->getHabitat(),
            $request->getHasVaccines(),
            $request->getVeterinarian()
        );
    }

    public function fromIdToGetByIdQuery(string $id): GetPetByIdQuery
    {
        return new GetPetByIdQuery($id);
    }

    public function fromIdToDeleteCommand(string $id): DeletePetCommand
    {
        return new DeletePetCommand($id);
    }

    public function fromModelToResponse(PetModel $pet): PetResponse
    {
        return new PetResponse(
            $pet->id()->value(),
            $pet->name()->value(),
            $pet->gender(),
            $pet->weight()->value(),
            $pet->size(),
            $pet->color()->value(),
            $pet->breed()->value(),
            $pet->species()->value(),
            $pet->birthDate()->value(),
            $pet->owner()->value(),
            $pet->habitat(),
            $pet->hasVaccines(),
            $pet->veterinarian()->value()
        );
    }

    public function fromModelsToResponses(array $pets): array
    {
        $responses = array();
        foreach ($pets as $pet) {
            $responses[] = $this->fromModelToResponse($pet);
        }
        return $responses;
    }
}
