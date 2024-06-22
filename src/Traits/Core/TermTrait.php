<?php

namespace App\Traits\Core;

use App\Entity\M\Master\Term;
use App\Repository\M\Master\TermRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;

/**
 * Trait term
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait TermTrait
{
    private $termRepository;

    public function addTerm(array $options): Term
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'id' => null,
            'slug' => null,
            'description' => null,
            'enabled' => true,
            'doFlush' => false,
        ]);

        $resolver->setRequired(["name","taxonomy"]);
        
        $options = $resolver->resolve($options);

        $term = new Term();
        $term->setName($options["name"]);
        $term->setTaxonomy($options["taxonomy"]);
        $term->setEnabled($options["enabled"]);

        if (null != $options["id"]) {
            $term->setId($options["id"]);
        } else {
            $term->setId(Uuid::v4());
        }

        if (null != $options["description"]) {
            $term->setDescription($options["description"]);
        }

        if (null != $options["slug"]) {
            $term->setSlug($options["slug"]);
        }

        $this->doPersist($term,false);
        // Do Flush Parse
        if (true == $options["doFlush"]) {
            $this->doFlush();
        }

        return $term;
    }

    public function findOneByTermBy(array $criteria = array())
    {
        return $this->termRepository->findOneBy($criteria);
    }

    public function findByTermBy(array $criteria = array(),array $order = array())
    {
        return $this->termRepository->findBy($criteria,$order);
    }


    /**
     * TermRepository
     *
     * @param   TermRepository  $termRepository]
     *
     * @required
     */
    public function setTermRepository(TermRepository $termRepository)
    {
        $this->termRepository = $termRepository;
    }
}
