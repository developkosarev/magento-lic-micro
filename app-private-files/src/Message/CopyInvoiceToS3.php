<?php
declare(strict_types=1);

namespace App\Message;

class CopyInvoiceToS3
{
    public function __construct(
        readonly private string $incrementId,
        readonly private string $createdAt
    ){}

    public function getIncrementId(): string
    {
        return $this->incrementId;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }
}