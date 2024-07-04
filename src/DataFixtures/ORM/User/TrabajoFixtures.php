<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures\ORM\User;

use App\Entity\M\Trabajo\Trabajo;
use Doctrine\Persistence\ObjectManager;
use App\Entity\M\User;
use App\Entity\M\User\MobileDevice;
use App\DataFixtures\ORM\BaseFixtures;
use App\Repository\M\Trabajo\TrabajoRepository;

class TrabajoFixtures extends BaseFixtures
{
    private $trabajoRepository;

    public function load(ObjectManager $manager)
    {
        
    }

    public function getOrder() 
    {
        return 20;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setInvestigationLineRepository(TrabajoRepository $trabajoRepository)
    {
        $this->trabajoRepository = $trabajoRepository;
    }
}
