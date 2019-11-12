<?php
declare(strict_types=1);

namespace App\Domain\User\Factory;

use App\Domain\User\Model\User;

class UserFactory
{
    public function create($id, $username, $name): User
    {
        return new User(
            (int)$id,
            (string)$username,
            (string)$name
        );
    }
}
