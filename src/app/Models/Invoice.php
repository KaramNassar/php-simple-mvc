<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Invoice extends Model
{

    public function create(int $userId, int $amount): int
    {
        $newInvoiceStmt = $this->db->prepare(
            'INSERT INTO invoices (user_id, amount) VALUES(?,?)'
        );

        $newInvoiceStmt->execute([$userId, $amount]);

        return (int)$this->db->lastInsertId();
    }

    public function find(int $invoiceId): array
    {
        $stmt = $this->db->prepare(
            'SELECT i.id, amount, u.username
             FROM invoices i
             LEFT JOIN users u
             ON i.user_id = u.id
             WHERE i.id = ?'
        );

        $stmt->execute([$invoiceId]);

        $invoice = $stmt->fetch();

        return $invoice ?? [];
    }

}