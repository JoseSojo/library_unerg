<?php

namespace App\Repository\M\User;

/**
 * GroupRepository
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GroupRepository extends \App\Repository\EntityRepository
{
	/**
	 * Alias
	 *  
	 * @author Máximo Sojo <maxsojo13@gmail.com>
	 * @return Alies
	 */
    public function getAlias()
    {
        return "ug";
    }
}