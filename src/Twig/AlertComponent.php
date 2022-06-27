<?php

declare(strict_types=1);

namespace App\Twig;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class AlertComponent
{
    public string $type = 'success';
    public string $message;

    public function getAlertTitle(): string
    {
        /** @phpstan-ignore-next-line */
        return match ($this->type) {
            'success' => 'Succès',
            'error' => 'Une erreur est survenue.',
        };
    }
}
