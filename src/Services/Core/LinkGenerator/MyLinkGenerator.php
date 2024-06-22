<?php

/*
 * This file is part of the Grupo Farmaingenio C.A. - J406111090 package.
 * 
 * (c) www.tconin.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services\Core\LinkGenerator;

use Maximosojo\ToolsBundle\Model\LinkGenerator\LinkGeneratorItem;

/**
 * Renderiza objetos como enlaces
 */
class MyLinkGenerator extends LinkGeneratorItem
{
    public static function getConfigObjects() 
    {
    	return [
            ['class' => 'App\Entity\M\User','labelMethod' => 'getFullName','icon' => 'ico ico-user','route' => 'app_route_admin_user_show']
        ];
    }
}
