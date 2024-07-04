<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures\ORM\Master;

use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ORM\BaseFixtures;
use App\Entity\M\Master\Trabajo\Program;

class ProgramFixtures extends BaseFixtures
{
    public function load(ObjectManager $manager)
    {
        

        // $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
