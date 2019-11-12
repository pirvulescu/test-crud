<?php
declare(strict_types=1);

namespace App\Domain\User\Repository;

use App\Domain\User\Model\User;
use App\Domain\User\Model\UserCollection;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findAll(): UserCollection;
    public function create(User $user): int;
    public function update(User $user): void;
    public function delete(int $id): void;
}
