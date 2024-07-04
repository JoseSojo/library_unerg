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
        $esp = new Category();
        $esp->setName("Especialización");
        $esp->setId(Category::ID_TEG);  
        $manager->persist($esp);

        $mgis = new Category();
        $mgis->setName("Maestria");
        $mgis->setId(Category::ID_TG);        
        $manager->persist($mgis);

        $doc = new Category();
        $doc->setName("Doctorado");
        $doc->setId(Category::ID_TD);        
        $manager->persist($doc);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
