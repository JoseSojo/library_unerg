<?php

namespace App\Entity\S\ObjectManager\HistoryManager;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ObjectManager\HistoryManager\DoctrineORM\ModelHistory;

/**
 * Historial de usuarios
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity]
#[ORM\Table(name: 'object_manager_history_manager_history')]
class History extends ModelHistory
{
}