<?php

namespace App\Controller\A;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class DefaultController extends AbstractDashboardController
{
    #[Route(path: '/test', name: 'api_easyadmin')]
	public function index(): Response
    {
        return parent::index();
    }    
}
