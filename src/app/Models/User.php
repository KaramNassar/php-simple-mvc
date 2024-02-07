<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{

    public function create(string $username, string $email): int
    {
        $newUserStmt = $this->db->prepare(
            'INSERT INTO users (username, email, is_active, created_at) VALUES(?, ?, 1, NOW())'
        );

        $newUserStmt->execute([$username, $email]);

        return (int)$this->db->lastInsertId();
    }

}