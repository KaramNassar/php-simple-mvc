<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{

    public function create(string $username, string $email): int
    {
        $this->queryBuilder
            ->insert('users')
            ->values([
                'username'   => '?',
                'email'      => '?',
                'is_active'  => 1,
                'created_at' => 'Now()',
            ])
            ->setParameter(0, $username)
            ->setParameter(1, $email)
            ->executeQuery();

        return (int)$this->db->lastInsertId();
    }

}