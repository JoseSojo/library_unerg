<?php

namespace App\Entity\M\Master\Trabajo;

use App\Model\Master\Trabajo\ModelType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Traits\ORM\SoftDeleteableTrait;
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
    #[ORM\Column(type: 'string', length: 20, nullable: false)]
    protected $id;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $processorId;

    use NameTrait;
    use EnableableTrait;
    use SoftDeleteableTrait;
    use TimestampableTrait;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set id
     *
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getProcessorId(): ?string
    {
        return $this->processorId;
    }

    public function setProcessorId(string $processorId): static
    {
        $this->processorId = $processorId;

        return $this;
    }
}