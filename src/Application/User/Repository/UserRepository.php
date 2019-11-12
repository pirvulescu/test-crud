<?php
declare(strict_types=1);

namespace App\Application\User\Repository;

use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Model\User;
use App\Domain\User\Model\UserCollection;
use App\Domain\User\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{

    private $pdo;
    private $userFactory;

    public function __construct(\PDO $pdo, UserFactory $userFactory)
    {
        $this->pdo = $pdo;
        $this->userFactory = $userFactory;
    }

    public function find(int $id): ?User
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE id = :id');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();

        if (!$userEntity = $statement->fetch()) {

            return null;
        }

        return  $this->userFactory->create(
                $userEntity['id'],
                $userEntity['username'],
                $userEntity['name']
            );
    }

    public function findAll(): UserCollection
    {
        $users = new UserCollection();

        $rez = $this->pdo->query('SELECT * FROM users');

        foreach ($rez->fetchAll() as $userEntity) {
            $users->addUser($this->userFactory->create(
                $userEntity['id'],
                $userEntity['username'],
                $userEntity['name']
            ));
        }

        return $users;
    }

    public function create(User $user): int
    {
        $statement = $this->pdo->prepare(
            'INSERT INTO `users` (`username`, `name`)
            VALUES
            (:username, :name)'
        );
        $statement->bindValue(':username', $user->getUsername());
        $statement->bindValue(':name', $user->getName());
        $statement->execute();

        return (int)$this->pdo->lastInsertId();
    }

    public function update(User $user): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE `users` 
            SET `username` = :username , `name` = :name
            WHERE `id` = :id'
        );
        $statement->bindValue(':username', $user->getUsername());
        $statement->bindValue(':name', $user->getName());
        $statement->bindValue(':id', $user->getId(), \PDO::PARAM_INT);
        $statement->execute();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare(
            'DELETE FROM `users` 
            WHERE `id` = :id'
        );
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
