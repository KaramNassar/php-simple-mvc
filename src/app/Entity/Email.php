<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enums\EmailStatus;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table('emails')]
#[HasLifecycleCallbacks]
class Email
{

    #[Id, GeneratedValue]
    #[Column]
    private int $id;

    #[Column]
    private string $subject;

    #[Column]
    private EmailStatus $status;

    #[Column(name: 'text_body')]
    private string $textBody;

    #[Column(name: 'html_body')]
    private string $htmlBody;

    #[Column(type: Types::JSON)]
    private array $meta;

    #[Column(name: 'created_at')]
    private DateTime $createdAt;

    #[Column(name: 'sent_at')]
    private DateTime $sentAt;

    #[PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new DateTime();
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getStatus(): EmailStatus
    {
        return $this->status;
    }

    public function setStatus(EmailStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getTextBody(): string
    {
        return $this->textBody;
    }

    public function setTextBody(string $textBody): static
    {
        $this->textBody = $textBody;

        return $this;
    }

    public function getHtmlBody(): string
    {
        return $this->htmlBody;
    }

    public function setHtmlBody(string $htmlBody): static
    {
        $this->htmlBody = $htmlBody;

        return $this;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): static
    {
        $this->meta = $meta;

        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSentAt(): DateTime
    {
        return $this->sentAt;
    }

    public function setSentAt(DateTime $sentAt): static
    {
        $this->sentAt = $sentAt;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

}