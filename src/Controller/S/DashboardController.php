<?php

namespace App\Controller\S;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/', name: 'easyadmin')]
	#[Route(path: '/', name: 'baseadmin_route_easyadmin_dashboard')]
    public function index(): Response
    {
        return parent::index();
    }    
}
