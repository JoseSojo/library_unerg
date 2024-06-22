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
use App\Entity\M\Master\Trabajo\Category;

class CategoryFixtures extends BaseFixtures
{
    public function load(ObjectManager $manager)
    {
        $tesis = new Category();
        $tesis->setName("Tesis");
        $tesis->setId(Category::ID_TESIS);        
        $tesis->setProcessorId(Category::ID_TESIS);
        $manager->persist($tesis);

        $trabajo = new Category();
        $trabajo->setName("Trabajo de grado");
        $trabajo->setId(Category::ID_TRABAJO);        
        $trabajo->setProcessorId(Category::ID_TRABAJO);
        $manager->persist($trabajo);

        $doctoral = new Category();
        $doctoral->setName("Tesis Doctoral");
        $doctoral->setId(Category::ID_DOCTORAL);        
        $doctoral->setProcessorId(Category::ID_DOCTORAL);
        $manager->persist($doctoral);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
