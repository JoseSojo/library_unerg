<?php

namespace App\Entity\M\Master\Trabajo;

use App\Model\Master\Trabajo\ModelType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\UserTrait;
use App\Traits\ORM\EnableableTrait;
use App\Traits\ORM\TimestampableTrait;

/**
 * Category
 *
 * @author José Sojo <jsojo346@gmail.com>
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\Master\Trabajo\CategoryRepository')]
#[ORM\Table(name: 'master_trabajo_categorys')]
class Category extends ModelType
{
    /**
     * @var string
     */
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    protected $id;

    use NameTrait;
    use SoftDeleteableTrait;
    use TimestampableTrait;

    public function __toString()
    {
        return $this->name;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }
}