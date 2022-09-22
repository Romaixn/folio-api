<?php

declare(strict_types=1);

namespace App\Project\Domain\Model;

use App\Project\Domain\ValueObject\ProjectContent;
use App\Project\Domain\ValueObject\ProjectExcerpt;
use App\Project\Domain\ValueObject\ProjectId;
use App\Project\Domain\ValueObject\ProjectTitle;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Project
{
    #[ORM\Embedded(columnPrefix: false)]
    public ProjectId $id;

    public function __construct(
        #[ORM\Embedded(columnPrefix: false)]
        public ProjectTitle $title,

        #[ORM\Embedded(columnPrefix: false)]
        public ProjectExcerpt $excerpt,

        #[ORM\Embedded(columnPrefix: false)]
        public ProjectContent $content,
    ) {
        $this->id = new ProjectId();
    }
}
