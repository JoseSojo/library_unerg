<?php

namespace App\Repository\S\Core;

/**
 * Repositorio hisotricos
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class HistoryRepository extends \App\Repository\EntityRepository
{
	/**
     * Paginador de compras 
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  array
     * @param  array
     * @return Paginator
     */
    public function createPaginator(array $criteria = array(),array $order = array())
    {
        $a = $this->getAlias();
        $criteria = $this->parseCriteria($criteria);
        $qb = $this->createQueryBuilder($a);
        $qb->select($a.".eventName event_name",$a.".createdAt created_at", $a.".description");
        $qb
            ->addSelect("u.id user_id","u.username")
            ->innerjoin($a.".createdBy","u")
            ;

        $this->applySorting($qb, $order);

        return $this->getPaginatorScalar($qb);
    }

    /**
     * Alias
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @return [type]
     */
    public function getAlias() 
    {
        return "h";
    }    
}
