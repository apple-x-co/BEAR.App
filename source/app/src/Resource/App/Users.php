<?php

declare(strict_types=1);

namespace MyVendor\MyProject\Resource\App;

use AppCore\Application\User\UserApplicationService;
use AppCore\Application\User\Command\UserCreateCommand;
use BEAR\RepositoryModule\Annotation\Purge;
use BEAR\Resource\Annotation\JsonSchema;
use BEAR\Resource\Annotation\Link;
use BEAR\Resource\ResourceObject;
use Koriym\HttpConstants\ResponseHeader;
use Koriym\HttpConstants\StatusCode;
use Ray\AuraSqlModule\Annotation\Transactional;

class Users extends ResourceObject
{
    /** @var UserApplicationService */
    private $userApplicationService;

    public function __construct(UserApplicationService $userApplicationService)
    {
        $this->userApplicationService = $userApplicationService;
    }

    /**
     * @return $this|ResourceObject
     *
     * @JsonSchema(schema="users.json")
     * @Link(rel="create", href="/users", method="post")
     */
    public function onGet(): ResourceObject
    {
        $generator = $this->userApplicationService->list();

        $users = [];
        foreach ($generator as $user) {
            $users[] = [
                'id' => $user->getId(),
                'username' => $user->getUserName(),
                'email' => $user->getEmail(),
            ];
        }

        $this->body = ['users' => $users];

        return $this;
    }

    /**
     * @return $this|ResourceObject
     *
     * @JsonSchema(schema="user.json", params="users.json")
     * @Transactional()
     * @Purge(uri="app://self/users")
     * @Link(rel="detail", href="/users/{id}")
     */
    public function onPost(
        string $username,
        string $email
    ): ResourceObject {
        $user = $this->userApplicationService->create(
            new UserCreateCommand(
                $username,
                $email
            )
        );

        $this->body['id'] = $user->getId();

        $this->code = StatusCode::CREATED;
        $this->headers[ResponseHeader::LOCATION] = '/users/' . $user->getId();

        return $this;
    }
}
