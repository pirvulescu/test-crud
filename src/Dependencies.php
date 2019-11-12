<?php
declare(strict_types=1);

namespace App;

use App\Application\User\Repository\UserRepository;
use App\Controllers\UserController;
use App\Domain\User\Factory\UserFactory;

class Dependencies
{
    private $dependencies = [];

    public function __construct()
    {
        $this->dependencies['userRepository'] = new UserRepository(
            new \PDO('mysql:dbname=app;host=mysql', 'app', 'password'),
            new UserFactory()
        );

        $this->dependencies['userController'] = new UserController(
            $this->dependencies['userRepository'],
            new UserFactory()
        );
    }

    public function get(string $name)
    {
        if (!array_key_exists($name, $this->dependencies)) {
            throw new \Exception('Dependencies not exists');
        }

        return $this->dependencies[$name];
    }
}
