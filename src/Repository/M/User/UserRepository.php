<?php

namespace App\Repository\M\User;

use App\Entity\M\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ServiceEntityRepository;
use App\Repository\EntityRepository;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Paginador de usuarios 
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  array
     * @param  array
     * @return Paginator
     */
    public function createPaginator(array $criteria = array(),array $order = array())
    {
        $criteria = $this->parseCriteria($criteria);
        
        $a = $this->getAlias();
        $qb = $this->getQueryBuilder();
        
        if (($type = $criteria->remove("type")) !== null) {
            if (!is_array($type)) {
                $type = [$type];
            }
            $qb
                ->andWhere($a.'.type IN(:type)')
                ->setParameter("type",$type)
                ;
        }

        if (($status = $criteria->remove("status")) != null) {
            if (!is_array($status)) {
                $status = [$status];
            }
            $qb
                ->andWhere($a.'.status IN(:status)')
                ->setParameter("status",$status)
                ;
        }

        $sqb = $this->createSearchQueryBuilder($qb, $criteria);
        $sqb
            ->addFieldLike(["firstname","lastname","username","email"])
            ->addFieldDateFromTo(['createdAt'])
            ;

        $this->applySorting($qb, $order);
        
        return $this->getPaginator($qb);
    }

	/**
	 * Alias
	 *  
	 * @author Máximo Sojo <maxsojo13@gmail.com>
	 * @return Alies
	 */
    public function getAlias()
    {
        return "u";
    }
}
