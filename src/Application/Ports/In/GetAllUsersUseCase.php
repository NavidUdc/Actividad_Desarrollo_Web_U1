<?php

declare(strict_types=1);

interface GetAllUsersUseCase
{
    /** @return UserModel[] */
    public function execute(GetAllUsersQuery $query): array;
}
