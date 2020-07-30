<?php

declare(strict_types=1);

namespace AppCore\UseCase\User\Get;

final class UserGetRequest
{
    private $id;

    /**
     * UserGetRequest constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}