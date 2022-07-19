<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\ArticleType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

final class NewsletterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextEditorField::new('content');
        yield CollectionField::new('articles')->setEntryType(ArticleType::class);
    }
}
