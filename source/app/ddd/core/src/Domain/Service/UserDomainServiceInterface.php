<?php

declare(strict_types=1);

namespace AppCore\Domain\Service;

use AppCore\Domain\Model\User\User;

interface UserDomainServiceInterface
{
    public function exists(User $user) : bool;
}