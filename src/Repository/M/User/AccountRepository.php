<?php

namespace App\Repository\M\User;

use App\Entity\M\User\Account;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Account>
 *
 * @method Account|null find($id, $lockMode = null, $lockVersion = null)
 * @method Account|null findOneBy(array $criteria, array $orderBy = null)
 * @method Account[]    findAll()
 * @method Account[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Account::class);
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
        
        if (($user = $criteria->remove("user")) !== null) {
            $qb
                ->andWhere($a.'.user = :user')
                ->setParameter("user",$user)
                ;
        }

        $this->applySorting($qb, $order);
        
        return $this->getPaginator($qb);
    }
}
