<?php

declare(strict_types=1);

namespace App\Contact\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Contact\State\ContactPostProcessor;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/contact',
            processor: ContactPostProcessor::class
        ),
    ],
)]
class Contact
{
    public function __construct(
        #[ApiProperty(readable: false, writable: false)]
        public ?Uuid $id = null,

        #[Assert\NotBlank]
        public ?string $firstName = null,

        #[Assert\NotBlank]
        public ?string $lastName = null,

        #[Assert\NotBlank]
        #[Assert\Email]
        public ?string $email = null,

        #[Assert\NotBlank]
        public ?string $subject = null,

        #[Assert\NotBlank]
        #[Assert\Length(
            max: 500,
            maxMessage: 'Your message is too long ({{ limit }} characters max).',
        )]
        public ?string $message = null,

        public ?string $phone = null
    ) {
        $this->id = Uuid::v4();
    }
}
