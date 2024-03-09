<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\App;
use App\Core\Model;

class User extends Model
{

    public function create(string $username, string $email): int
    {
        $user = (new \App\Entity\User())
            ->setUsername($username)
            ->setEmail($email)
            ->setIsActive(true);

        App::entityManager()->persist($user);
        App::entityManager()->flush();

        return $user->getId();
    }

}