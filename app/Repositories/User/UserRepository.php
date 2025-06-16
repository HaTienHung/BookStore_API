<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\RepositoryAbstract;

class UserRepository extends BaseRepository implements UserInterface
{
    public function model()
    {
        return User::class;
    }
    public function __construct(protected User $user)
    {
        parent::__construct($user);
    }
}
