<?php

declare(strict_types=1);

namespace AppCore\Application\User\Get;

use AppCore\Domain\User\UserRepositoryInterface;
use Generator;

class UserListUseCase
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * UserListUseCase constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @inheritDoc
     */
    public function handle(): Generator
    {
        $generator = $this->userRepository->find();

        foreach ($generator as $user) {
            yield new UserListOutputData($user);
        }
    }
}
