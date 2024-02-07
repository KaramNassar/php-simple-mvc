<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use Throwable;

class SignUp extends Model
{

    public function __construct(
        protected User $userModel,
        protected Invoice $invoiceModel
    ) {
        parent::__construct();
    }

    public function register(array $userInfo, array $invoiceInfo): int
    {
        try {
            $this->db->beginTransaction();

            $userId    = $this->userModel->create(
                $userInfo['username'],
                $userInfo['email']
            );
            $invoiceId = $this->invoiceModel->create(
                $userId,
                $invoiceInfo['amount']
            );

            $this->db->commit();

            return $invoiceId;
        } catch (Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }

}