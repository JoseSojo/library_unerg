<?php

namespace App\Entity\M\Master\Trabajo;

use Ramsey\Uuid\Doctrine\UuidGenerator;
use App\Model\Master\Trabajo\ModelType;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Entity\M\Master\Trabajo\Program;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\EnableableTrait;
use App\Traits\ORM\TimestampableTrait;

/**
 * InvestigationLine
 *
 * @author José Sojo <jsojo346@gmail.com>
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\Master\Trabajo\InvestigationLineRepository')]
#[ORM\Table(name: 'master_trabajo_investigation_line')]
class InvestigationLine extends ModelType
{
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 36)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected $id;

    use NameTrait;
    use EnableableTrait;
    use SoftDeleteableTrait;
    use TimestampableTrait;

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId(string $name): static
    {
        $this->id = "id_".$name."_line";

        return $this;
    }

}