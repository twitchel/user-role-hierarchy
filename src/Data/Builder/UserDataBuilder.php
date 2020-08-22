<?php


namespace UserRoleHierarchy\Data\Builder;


use UserRoleHierarchy\Entity\Builder\UserBuilder;
use UserRoleHierarchy\Entity\User;
use UserRoleHierarchy\Support\Collection;

class UserDataBuilder
{
    private UserBuilder $userBuilder;

    public function __construct(UserBuilder $userBuilder)
    {
        $this->userBuilder = $userBuilder;
    }

    public function build(array $userData): Collection
    {
        $collection = [];
        foreach ($userData as $userDatum) {
            $user = $this->userBuilder->build($userDatum);

            if ($user instanceof User) {
                $collection[] = $user;
            }
        }

        return new Collection($collection);
    }
}