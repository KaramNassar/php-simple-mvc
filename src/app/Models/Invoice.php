<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Invoice extends Model
{

    public function create(int $userId, int $amount): int
    {
        $this->queryBuilder->insert('invoices')
            ->values([
                'user_id' => '?',
                'amount'  => '?',
            ])
            ->setParameter(0, $userId)
            ->setParameter(1, $amount)
            ->executeQuery();

        return (int)$this->db->lastInsertId();
    }

    public function find(int $invoiceId): array
    {
        $invoice = $this->queryBuilder
            ->select('*')
            ->from('invoices', 'i')
            ->leftJoin('i', 'users', 'u', 'u.id = i.user_id')
            ->where('i.id = ?')
            ->setParameter(0, $invoiceId)
            ->fetchAssociative();

        return $invoice ?? [];
    }

    public function all(): array
    {
        return $this->queryBuilder
            ->select('*')
            ->from(
                'invoices'
            )->fetchAllAssociative();
    }

}