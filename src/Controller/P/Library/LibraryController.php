<?php

namespace App\Controller\P\Library;

use App\Repository\M\User\UserRepository;
use App\Repository\M\Trabajo\TrabajoRepository;
use App\Repository\M\Master\Trabajo\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class LibraryController extends AbstractDashboardController
{
    private $userRespository;
    private $workRespository;
    private $workCategoryRespository;

	#[Route(path: '/libreria', name: 'baseadmin_route_library')]
    public function index(): Response
    {
        $results = [];

        $results["ok"] = 20;

        return $this->render('@EasyAdmin/library/library.html.twig', [
            'prop1' => 'Hola',
            'prop2' => 'Mundo',
        ]);
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
