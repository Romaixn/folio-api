<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\Doctrine;

use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;
use App\Infrastructure\Shared\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

final class DoctrineProjectRepository extends DoctrineRepository implements ProjectRepositoryInterface
{
    private const ENTITY_CLASS = Project::class;
    private const ALIAS = 'project';

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct($em, self::ENTITY_CLASS, self::ALIAS);
    }

    public function add(Project $project): void
    {
        $this->em->persist($project);
        $this->em->flush();
    }

    public function remove(Project $project): void
    {
        $this->em->remove($project);
        $this->em->flush();
    }

    public function ofSlug(string $slug): ?Project
    {
        return $this->em->getRepository(self::ENTITY_CLASS)->findOneBy(['slug' => $slug]);
    }

    public function withCategory(string $category): static
    {
        return $this->filter(static function (QueryBuilder $qb) use ($category): void {
            $qb->where(sprintf('%s.category = :category', self::ALIAS))->setParameter('category', $category);
        });
    }
}
