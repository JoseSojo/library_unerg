<?php

namespace App\Entity\M\Master;

use App\Services\Util\StringUtil;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Traits\ORM\Basic\NameTrait;
use App\Traits\ORM\Basic\DescriptionTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\Basic\ExtraDataTrait;
use App\Traits\ORM\EnableableTrait;
use App\Traits\ORM\PriorityTrait;
use App\Traits\ORM\PriorityInterface;

/**
 * Terminos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\Master\TermRepository')]
#[ORM\Table(name: 'master_terms')]
class Term implements PriorityInterface
{
    public const TAXONOMY_COUNTRY = "country";
    public const TAXONOMY_CURRENCY = "currency";
    public const TAXONOMY_CHAIN = "chain";
    public const TAXONOMY_TYPE_OPERATION = "type_operation";
    public const TAXONOMY_OPERATION_METHOD = "operation_method";
    public const TAXONOMY_COMMISSION = "commission";
    public const TAXONOMY_BANK = "bank";
    public const TAXONOMY_BANK_ACCOUNT = "bank_account";
    public const TAXONOMY_SPORT = "sport";
    public const TAXONOMY_LEAGUE = "league";
    public const TAXONOMY_STADIUM = "stadium";

    /**
     * @var string
     */
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 50, nullable: false)]
    protected $id;

    /**
     * Slug
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    /**
     * Taxonomia
     * @var string
     */
    #[ORM\Column(type: 'string', length: 50)]
    private $taxonomy;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\M\Master\Term', inversedBy: "parents")]
    #[ORM\JoinTable(name: 'master_terms_relationships')]
    private $childs;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\M\Master\Term', mappedBy: "childs")]
    private $parents;

    use NameTrait;
    use DescriptionTrait;
    use EnableableTrait;
    use SoftDeleteableTrait;
    use PriorityTrait;

    public function __construct()
    {
        $this->childs = new ArrayCollection();
        $this->parents = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set id
     *
     * @param string $id
     * @return Term
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getTaxonomy(): ?string
    {
        return $this->taxonomy;
    }

    public function setTaxonomy(string $taxonomy): self
    {
        $this->taxonomy = $taxonomy;

        return $this;
    }

    /**
     * @return Collection<int, Term>
     */
    public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(Term $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs->add($child);
        }

        return $this;
    }

    public function removeChild(Term $child): self
    {
        $this->childs->removeElement($child);

        return $this;
    }

    /**
     * @return Collection<int, Term>
     */
    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function addParent(Term $parent): self
    {
        if (!$this->parents->contains($parent)) {
            $this->parents->add($parent);
            $parent->addChild($this);
        }

        return $this;
    }

    public function removeParent(Term $parent): self
    {
        if ($this->parents->removeElement($parent)) {
            $parent->removeChild($this);
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }
}