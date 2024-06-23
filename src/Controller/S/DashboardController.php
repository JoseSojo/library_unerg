<?php

namespace App\Controller\S;

use App\Repository\M\User\UserRepository;
use App\Repository\M\Trabajo\TrabajoRepository;
use App\Repository\M\Master\Trabajo\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $userRespository;
    private $workRespository;
    private $workCategoryRespository;

    #[Route(path: '/', name: 'easyadmin')]
	#[Route(path: '/', name: 'baseadmin_route_easyadmin_dashboard')]
    public function index(): Response
    {
        $request = $this->container->get('request_stack')->getCurrentRequest();
        // Verificamos si es un crud o el dashboard
        if (null === $request->query->get('crudControllerFqcn')) {
            $results = [];

            // Users
            $results["userData"]["count"] = $this->userRespository->countAll();
            $results["userData"]["url"] =  "App\\Controller\\S\\Admin\\UserCrudController";

            // Works
            $results["workData"]["count"] = $this->workRespository->countAll();
            $results["workData"]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\TrabajoCrudController";

            // Cateogries
            $results["cateogryData"]["count"] = $this->workCategoryRespository->countAll();
            $results["cateogryData"]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\CategoryCrudController";

            return $this->render('@EasyAdmin/welcome.html.twig', [
                "results" => $results,
            ]);
        }

        return parent::index();
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
