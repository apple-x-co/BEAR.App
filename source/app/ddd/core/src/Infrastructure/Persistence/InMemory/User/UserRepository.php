<?php
declare(strict_types=1);
namespace AppCore\Infrastructure\Persistence\InMemory\User;

use AppCore\Domain\Model\User\Exception\UserNotFoundException;
use AppCore\Domain\Model\User\User;
use AppCore\Domain\Model\User\UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    /** @var User[] */
    private $users = [];

    /**
     * {@inheritdoc}
     */
    public function get(int $id) : User
    {
        $users = $this->find(['id' => $id], []);
        if (empty($users)) {
            throw new UserNotFoundException(sprintf('id : %d', $id));
        }

        return $users[0];
    }

    /**
     * {@inheritdoc}
     */
    public function count(array $conditions) : int
    {
        $conditions = $this->makeWhere($conditions);

        return count($this->users);
    }

    /**
     * {@inheritdoc}
     */
    public function find(array $conditions, array $options = []) : array
    {
        $conditions = $this->makeWhere($conditions);

        return $this->users;
    }

    /**
     * {@inheritdoc}
     */
    public function one(array $conditions, array $options = []) : ?User
    {
        $users = $this->find($conditions, []);
        if (empty($users)) {
            return null;
        }

        return $users[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getAll(array $options = []) : array
    {
        return $this->find([], $options);
    }

    /**
     * {@inheritdoc}
     */
    public function store(User $user) : void
    {
        if ($user->isNew()) {
            $this->users[] = $user;

            return;
        }

        if ($user->isDirty()) {
            return;
        }

        // update
    }

    /**
     * {@inheritdoc}
     */
    public function remove(User $user) : void
    {
        // TODO: Implement remove() method.
    }

    /**
     * {@inheritdoc}
     */
    public function toRawData(User $user) : array
    {
        return [
            'user_name' => $user->getUserName()->val(),
            'email' => $user->getEmail()->val()
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function makeWhere(array $conditions) : array
    {
        return $conditions;
    }
}
