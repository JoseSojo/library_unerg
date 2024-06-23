<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\DataFixtures\ORM;

use Doctrine\Persistence\ObjectManager;
use App\Entity\M\User;
use App\Services\User\UserManager;
use App\DataFixtures\ORM\BaseFixtures;
use League\Bundle\OAuth2ServerBundle\Manager\ClientManagerInterface;

class UserFixtures extends BaseFixtures
{
    /**
     * @var ClientManagerInterface
     */
    private $clientManager;

    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(ClientManagerInterface $clientManager, UserManager $userManager)
    {
        $this->clientManager = $clientManager;
        $this->userManager = $userManager;
    }

    public function load(ObjectManager $manager)
    {
        $users = [
            [
                "firstname" => "Autor 1",
                "lastname" => "UNERG",
                "username" => "author01",
                "identification" => "00000003",
                "type" => User::TYPE_AUTHOR
            ],
            [
                "firstname" => "Autor 2",
                "lastname" => "Libreria",
                "username" => "author02",
                "identification" => "00000002",
                "type" => User::TYPE_AUTHOR
            ],
            [
                "firstname" => "Super Admin",
                "lastname" => "APP",
                "username" => "superadmin",
                "identification" => "00000001",
                "superadmin" => true,
                "type" => User::TYPE_ADMIN
            ],
            [
                "firstname" => "Admin",
                "lastname" => "APP",
                "username" => "admin",
                "identification" => "00000000",
                "superadmin" => true,
                "type" => User::TYPE_ADMIN
            ]
        ];
        
        foreach ($users as $value) {
            $user = new User();
            
            if (isset($value["superadmin"]) && $value["superadmin"] == true) {
                $user->setSuperAdmin(true);
            }

            $password = "abc.12345";
            
            $username = $value["username"];
            $email = sprintf("%s@example.com",$username);
            $user->setIdentification($value["identification"]);
            $user->setPlainPassword($password);
            $user->setEnabled(true);
            $user->setFirstname($value["firstname"]);
            $user->setLastname($value["lastname"]);
            $user->setType($value["type"]);
            $user->setEmail($email);
            $user->setPhone(sprintf("424%s",\Maxtoan\Common\Util\StringUtil::getRamdomNumber(7)));
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder() 
    {
        return 20;
    }
}
