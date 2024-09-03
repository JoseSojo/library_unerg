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

use App\Entity\M\Group;
use Doctrine\Persistence\ObjectManager;
use App\Entity\M\User;
use App\Entity\M\User\MobileDevice;
use App\DataFixtures\ORM\BaseFixtures;

class GroupFixtures extends BaseFixtures
{
    public function load(ObjectManager $manager)
    {
        $groups = [
            "Administrador" => [
                "ROLE_ADMIN_USER_PROFILE",
                "ROLE_ADMIN_USER_LIST",
                "ROLE_ADMIN_USER_SHOW",
                "ROLE_ADMIN_USER_CREATE",
                "ROLE_ADMIN_USER_UPDATE",
                "ROLE_ADMIN_USER_DELETE",
                "ROLE_ADMIN_USER_SEARCH",
                "ROLE_ADMIN_USER_GROUP_PROFILE",
                "ROLE_ADMIN_USER_GROUP_LIST",
                "ROLE_ADMIN_USER_GROUP_SHOW",
                "ROLE_ADMIN_USER_GROUP_CREATE",
                "ROLE_ADMIN_USER_GROUP_UPDATE",
                "ROLE_ADMIN_USER_GROUP_DELETE",
                "ROLE_ADMIN_USER_GROUP_SEARCH",

                "ROLE_ADMIN_USER_PROFILE",
                "ROLE_ADMIN_USER_LIST",
                "ROLE_ADMIN_USER_SHOW",
                "ROLE_ADMIN_USER_CREATE",
                "ROLE_ADMIN_USER_UPDATE",
                "ROLE_ADMIN_USER_DELETE",
                "ROLE_ADMIN_USER_SEARCH",
                
                "ROLE_ADMIN_WORK_LIST",
                "ROLE_ADMIN_WORK_SHOW",
                "ROLE_ADMIN_WORK_CREATE",
                "ROLE_ADMIN_WORK_UPDATE",
                "ROLE_ADMIN_WORK_DELETE",
                "ROLE_ADMIN_WORK_SEARCH",

                "ROLE_ADMIN_WORK_CATEGORY_LIST",
                "ROLE_ADMIN_WORK_CATEGORY_SHOW",
                "ROLE_ADMIN_WORK_CATEGORY_CREATE",
                "ROLE_ADMIN_WORK_CATEGORY_UPDATE",
                "ROLE_ADMIN_WORK_CATEGORY_DELETE",                
                "ROLE_ADMIN_WORK_CATEGORY_SEARCH",

                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_LIST",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_SHOW",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_CREATE",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_UPDATE",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_DELETE",                
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_SEARCH",

                "ROLE_ADMIN_WORK_PROGRAM_LIST",                
                "ROLE_ADMIN_WORK_PROGRAM_SHOW",
                "ROLE_ADMIN_WORK_PROGRAM_CREATE",
                "ROLE_ADMIN_WORK_PROGRAM_DELETE",                
                "ROLE_ADMIN_WORK_PROGRAM_SEARCH",
                "ROLE_ADMIN_WORK_PROGRAM_UPDATE",
            ],
            "Coordinador" => [
                "ROLE_ADMIN_USER_PROFILE",
                "ROLE_ADMIN_USER_LIST",
                "ROLE_ADMIN_USER_SHOW",
                "ROLE_ADMIN_USER_CREATE",
                "ROLE_ADMIN_USER_UPDATE",
                "ROLE_ADMIN_USER_DELETE",
                "ROLE_ADMIN_USER_SEARCH",
                
                "ROLE_ADMIN_WORK_LIST",
                "ROLE_ADMIN_WORK_SHOW",
                "ROLE_ADMIN_WORK_CREATE",
                "ROLE_ADMIN_WORK_UPDATE",
                "ROLE_ADMIN_WORK_DELETE",

                "ROLE_ADMIN_WORK_CATEGORY_LIST",
                "ROLE_ADMIN_WORK_CATEGORY_SHOW",
                "ROLE_ADMIN_WORK_CATEGORY_CREATE",
                "ROLE_ADMIN_WORK_CATEGORY_UPDATE",
                "ROLE_ADMIN_WORK_CATEGORY_DELETE",

                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_LIST",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_SHOW",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_CREATE",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_UPDATE",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_DELETE",

                "ROLE_ADMIN_WORK_PROGRAM_LIST",                
                "ROLE_ADMIN_WORK_PROGRAM_SHOW",
                "ROLE_ADMIN_WORK_PROGRAM_CREATE",
                "ROLE_ADMIN_WORK_PROGRAM_DELETE",
                "ROLE_ADMIN_WORK_PROGRAM_UPDATE",
            ],
            "Autor" => [                
                "ROLE_ADMIN_WORK_LIST",
                "ROLE_ADMIN_WORK_SHOW",
                "ROLE_ADMIN_WORK_CREATE",
                "ROLE_ADMIN_WORK_CATEGORY_LIST",
                "ROLE_ADMIN_WORK_INVESTIGATION_LINE_LIST",
                "ROLE_ADMIN_WORK_PROGRAM_LIST",
            ],
        ];
        
        foreach ($groups as $key => $group) {
            $entity = new Group();
            $entity->setName($key);
            $entity->setRoles($group);
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public function getOrder() 
    {
        return 20;
    }
}
