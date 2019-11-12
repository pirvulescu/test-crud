<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Domain\User\Factory\UserFactory;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController
{
    private $userRepository;
    private $userFactory;

    public function __construct(UserRepositoryInterface $userRepository, UserFactory $userFactory)
    {
        $this->userRepository = $userRepository;
        $this->userFactory = $userFactory;
    }

    public function get($userId): Response
    {

        if (!$user = $this->userRepository->find((int)$userId)) {
            return new Response('[]');
        }

        return new Response(json_encode(
            [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'name' => $user->getName()
            ]
        ));
    }

    public function post(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) || !isset($data['username'])) {
            throw new \Exception('Invalid input data');
        }

        $user = $this->userFactory->create(
            -1,
            $data['username'],
            $data['name']
        );

        $id = $this->userRepository->create($user);
        $user->setId((int)$id);

        return new Response(json_encode($this->mapUser($user)));
    }

    public function list(): Response
    {
        $users = $this->userRepository->findAll();

        $return = [];

        foreach ($users as $user) {
            $return[] = $this->mapUser($user);
        }

        return new Response(json_encode($return));
    }

    public function put(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id']) || !isset($data['name']) || !isset($data['username'])) {
            throw new \Exception('Invalid input data');
        }

        if (!$user = $this->userRepository->find((int)$data['id'])) {
            throw new \Exception('User not found');
        }

        $user->setUsername($data['username']);
        $user->setName($data['name']);

        $this->userRepository->update($user);

        return new Response(json_encode($this->mapUser($user)));
    }

    public function delete($userId): Response
    {
        if (!$user = $this->userRepository->find((int)$userId)) {
            throw new \Exception('User not found');
        }

        $this->userRepository->delete((int)$userId);

        return new Response('Success');
    }

    private function mapUser(User $user): array
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'name' => $user->getName()
        ];
    }
}
