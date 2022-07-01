<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Project;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['updatedAt' => 'desc'])
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('categories')
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield BooleanField::new('isPublished')->renderAsSwitch();
        yield TextField::new('state')->setFormTypeOption('disabled', true)->hideOnIndex();
        yield TextField::new('title');
        yield SlugField::new('slug')->setTargetFieldName('title');
        yield TextEditorField::new('description')->hideOnIndex()->setTrixEditorConfig([
            'blockAttributes' => [
                'default' => ['tagName' => 'p'],
                'heading1' => ['tagName' => 'h2'],
            ],
        ]);
        yield ImageField::new('photoFilename')
            ->setBasePath('uploads/images')
            ->setUploadDir('public/uploads/images')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setLabel('Image')
        ;
        yield AssociationField::new('categories')->setFormTypeOption('by_reference', false);
        yield DateField::new('createdAt')->setFormTypeOption('disabled', true)->hideOnIndex();
        yield DateField::new('updatedAt')->setFormTypeOption('disabled', true);
    }
}
