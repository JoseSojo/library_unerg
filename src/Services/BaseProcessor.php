<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 *
 * (c) www.companyname.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace App\Services;

use App\Exception\NotImplementedException;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Maximosojo\ToolsBundle\Controller\ControllerTrait;
use Maximosojo\ToolsBundle\Component\FOS\RestBundle\View\FOSRestViewTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use LogicException;
use App\Services\BaseService;

/**
 * Base de procesador
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class BaseProcessor extends BaseService
{
    use ControllerTrait;
    use FOSRestViewTrait;
}
