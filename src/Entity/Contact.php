<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: ['post' => [
        'path' => 'contact',
    ]],
    itemOperations: ['get' => [
        'openapi_context' => [
            'summary' => 'hidden',
        ],
    ]],
)]
class Contact
{
    #[ApiProperty(identifier: true)]
    private ?string $id = null;

    #[Assert\NotBlank]
    private string $firstName;

    #[Assert\NotBlank]
    private string $lastName;

    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    private ?string $phone = null;

    #[Assert\NotBlank]
    private string $subject;

    #[Assert\NotBlank]
    #[Assert\Length(
        max: 500,
        maxMessage: 'Your message is too long ({{ limit }} characters max).',
    )]
    private string $message;

    public function __construct()
    {
        $this->id = Uuid::v4()->toRfc4122();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }
}
