<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, unique: true, nullable: false)]
    private ?string $incrementId;

    #[ORM\Column(type: Types::BOOLEAN)]
    private ?bool $copied;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIncrementId(): ?string
    {
        return $this->incrementId;
    }

    public function setIncrementId(string $incrementId): static
    {
        $this->incrementId = $incrementId;
        return $this;
    }

    public function getCopied(): ?string
    {
        return $this->copied;
    }

    public function setCopied(bool $copied): static
    {
        $this->copied = $copied;
        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }
}
