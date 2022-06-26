<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[UniqueEntity(fields: ['slug'], errorPath: 'title', message: 'project.slug_unique')]
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'project:list']]],
    itemOperations: ['get' => ['normalization_context' => ['groups' => 'project:item']]],
    order: ['updatedAt' => 'DESC', 'createdAt' => 'DESC'],
)]
#[ApiFilter(SearchFilter::class, properties: ['categories' => 'exact'])]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['project:list', 'project:item'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    #[Groups(['project:list', 'project:item'])]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(min: 10, minMessage: 'project.too_short_content')]
    #[Groups(['project:item'])]
    private ?string $description = null;

    #[ORM\Column(type: 'string', nullable: true)]
    #[Assert\Url]
    #[Groups(['project:item'])]
    private ?string $url = null;

    #[ORM\Column(type: 'string')]
    #[Groups(['project:list', 'project:item'])]
    private ?string $slug = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable')]
    private \DateTimeImmutable $updatedAt;

    #[ORM\Column(type: 'string', options: ['default' => 'draft'])]
    private string $state = 'draft';

    #[ORM\Column(type: 'boolean', options: ['default' => false])]
    private bool $isPublished = false;

    /**
     * @var Category[]|Collection
     */
    #[ORM\ManyToMany(targetEntity: Category::class, mappedBy: 'projects')]
    #[Assert\Count(max: 4, maxMessage: 'project.too_many_categories')]
    #[Groups(['project:list', 'project:item'])]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function computeSlug(SluggerInterface $slugger): void
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): self
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addProject($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeProject($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
