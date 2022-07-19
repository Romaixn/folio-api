<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Subscriber;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

final class SubscriberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subscriber::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield EmailField::new('email');
        yield DateTimeField::new('createdAt')->hideOnForm();
    }
}
