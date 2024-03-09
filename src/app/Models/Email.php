<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\App;
use App\Core\Model;
use App\Enums\EmailStatus;
use DateTime;
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

        $email = (new \App\Entity\Email())
            ->setSubject($subject)
            ->setStatus(EmailStatus::Queue)
            ->setTextBody($text)
            ->setHtmlBody($html)
            ->setMeta($meta);

        App::entityManager()->persist($email);
        App::entityManager()->flush();
    }

    public function getEmailByStatus(EmailStatus $status): array
    {
        $queryBuilder = App::entityManager()->createQueryBuilder();

        return $queryBuilder
            ->select('e')
            ->from(\App\Entity\Email::class, 'e')
            ->where('e.status = :status')
            ->setParameter('status', $status->value)
            ->getQuery()
            ->getArrayResult();
    }

    public function markEmailSent($id): void
    {
        $email = App::entityManager()->find(\App\Entity\Email::class, $id);

        $email->setStatus(EmailStatus::Sent);
        $email->setSentAt(new DateTime());

        App::entityManager()->flush();
    }

}