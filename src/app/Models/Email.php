<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Enums\EmailStatus;
use Symfony\Component\Mime\Address;

class Email extends Model
{

    public function queue(
        Address $to,
        Address $from,
        string $subject,
        string $html,
        ?string $text = null
    ): void {
        $meta['to']   = $to->toString();
        $meta['from'] = $from->toString();

        $this->queryBuilder
            ->insert('emails')
            ->values([
                'subject'    => '?',
                'status'     => '?',
                'text_body'  => '?',
                'html_body'  => '?',
                'meta'       => '?',
                'created_at' => 'NOW()',
            ])
            ->setParameter(0, $subject)
            ->setParameter(1, EmailStatus::Queue->value)
            ->setParameter(2, $text)
            ->setParameter(3, $html)
            ->setParameter(4, json_encode($meta))
            ->executeQuery();
    }

    public function getEmailByStatus(EmailStatus $status): array
    {
        return $this->queryBuilder
            ->select('*')
            ->from('emails')
            ->where('status = ?')
            ->setParameter(0, $status->value)
            ->fetchAllAssociative();
    }

    public function markEmailSent($id): void
    {
        $this->queryBuilder
            ->update('emails')
            ->set('status', '?')
            ->set('sent_at', 'NOW()')
            ->setParameter(0, EmailStatus::Sent->value)
            ->setParameter(1, $id)
            ->where('id = ?')
            ->executeQuery();
    }

}