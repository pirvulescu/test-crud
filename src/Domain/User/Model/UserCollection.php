<?php
declare(strict_types=1);

namespace App\Domain\User\Model;

class UserCollection implements \IteratorAggregate
{
    protected $users = [];

    public function addUser(User $user): void
    {
        $this->users[$user->getId()] = $user;
    }

    /**
     * @return User[]|\ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->users);
    }
}
