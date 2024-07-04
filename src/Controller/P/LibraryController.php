<?php

namespace App\Controller\P;

use App\Repository\M\User\UserRepository;
use App\Repository\M\Trabajo\TrabajoRepository;
use App\Repository\M\Master\Trabajo\CategoryRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class LibraryController extends AbstractDashboardController
{
    private $userRespository;
    private $workRespository;
    private $workCategoryRespository;

	#[Route(path: '/', name: 'baseadmin_route_library')]
    public function index(): Response
    {
        if($this->getUser()) {
            return new RedirectResponse('dashboard');
        }

        $results = [];

        $results["ok"] = 20;

        return $this->render('@EasyAdmin/library/library.html.twig');
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setUserRepository(UserRepository $userRepository)
    {
        $this->userRespository = $userRepository;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setWorkRepository(TrabajoRepository $workRespository)
    {
        $this->workRespository = $workRespository;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setWorkCateogryRepository(CategoryRepository $workCategoryRespository)
    {
        $this->workCategoryRespository = $workCategoryRespository;
    }
}
