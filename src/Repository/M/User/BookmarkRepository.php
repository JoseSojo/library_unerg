<?php

namespace App\Repository\M\User;

use App\Entity\M\User\Bookmark;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ServiceEntityRepository;
use App\Repository\EntityRepository;

/**
 * @extends ServiceEntityRepository<Bookmark>
 *
 * @method Bookmark|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bookmark|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bookmark[]    findAll()
 * @method Bookmark[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BookmarkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bookmark::class);
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
        $criteria = $this->parseAndCleanCriteria($criteria);
        
        $a = $this->getAlias();
        $qb = $this->createQueryBuilder($a);

        if(($user = $criteria->remove("user")) != null){
            $qb
                ->andWhere($a.".user = :user")
                ->setParameter("user", $user)
                ;            
        }

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
        return "ub";
    }
}
