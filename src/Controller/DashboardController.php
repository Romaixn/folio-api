<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Group;
use App\Entity\Newsletter;
use App\Entity\Project;
use App\Entity\Subscriber;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class DashboardController extends AbstractDashboardController
{
    #[Route('/', name: 'dashboard')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(ProjectCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img style="height:2rem" src="build/images/logo-typo.svg">')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Go to website', 'fas fa-home', 'https://rherault.fr');
        yield MenuItem::linkToUrl('Healthcheck', 'fas fa-heartbeat', 'https://status.rherault.fr');
        yield MenuItem::linkToUrl('Go to API docs', 'fas fa-book', '/api/docs');

        yield MenuItem::section('Projects');
        yield MenuItem::linkToCrud('Project', 'fas fa-list', Project::class);
        yield MenuItem::linkToCrud('Category', 'fas fa-tag', Category::class);

        yield MenuItem::section('Newsletter');
        yield MenuItem::linkToCrud('Newsletter', 'fas fa-newspaper', Newsletter::class);
        yield MenuItem::linkToCrud('Article category', 'fas fa-tag', Group::class);
        yield MenuItem::linkToCrud('Subscriber', 'fas fa-user-friends', Subscriber::class);
    }
}
