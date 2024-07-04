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
use App\DataFixtures\ORM\BaseFixtures;
use Maximosojo\ToolsBundle\Service\OptionManager\OptionManagerTrait;

class AppFixtures extends BaseFixtures
{
    use OptionManagerTrait;

    public function load(ObjectManager $manager)
    {        
        // Configuraciones
        $this->loadConfigurations();

        $manager->flush();
    }

    public function loadConfigurations()
    {
        $array = [
            "APP_NAME" => [
                "value" => "Libreria",
                "description" => "Nombre de la aplicación."
            ],
            "APP_BUSINESS_NAME" => [
                "value" => "UNERG",
                "description" => "Nombre de la aplicación."
            ],
            "APP_DESCRIPTION" => [
                "value" => "Biblioteca postgrado unerg",
                "description" => "Descripción de la aplicación."
            ],
            "APP_LOCALE" => [
                "value" => "es",
                "description" => "Idioma por defecto."
            ],
            "APP_WEBSITE" => [
                "value" => "http://app.companyname.com",
                "description" => "Sitio web."
            ],
            "APP_ADDRESS" => [
                "value" => "San Juan de los Morros, Guárico",
                "description" => "Dirección."
            ],
            "APP_PHONE" => [
                "value" => "+584240000010",
                "description" => "Teléfono."
            ]
        ];

        foreach ($array as $key => $value) {
            $this->optionManager->set($key,$value["value"]);
        }

        $this->optionManager->flush();
    }

    public function getOrder() 
    {
        return 10;
    }
}
