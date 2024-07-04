<?php

namespace App\Controller\S;

use App\Repository\M\User\UserRepository;
use App\Repository\M\Trabajo\TrabajoRepository;
use App\Repository\M\Master\Trabajo\CategoryRepository;
use App\Repository\M\Master\Trabajo\InvestigationLineRepository;
use App\Repository\M\Master\Trabajo\ProgramRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DashboardController extends AbstractDashboardController
{
    private $userRespository;
    private $workRespository;
    private $workCategoryRespository;
    private $programRespository;
    private $investigationLineRespository;

    #[Route(path: '/dashboard', name: 'easyadmin')]
	#[Route(path: '/dashboard', name: 'baseadmin_route_easyadmin_dashboard')]
    public function index(): Response
    {
        if(null === $this->getUser()) {
            $response = new RedirectResponse('/login');
            return $response;
        }

        $request = $this->container->get('request_stack')->getCurrentRequest();
        // Verificamos si es un crud o el dashboard
        if (null === $request->query->get('crudControllerFqcn')) {
            $results = [];
            $roles = $this->getUser()->getRoles();

            $isSuperAdmin = in_array('ROLE_SUPER_ADMIN', $roles);
            // $isAuthor = in_array('ROLE_AUTHOR', $roles);
            // $isCoordinador = in_array('ROLE_COORDINADOR', $roles);


            $worksOwner = $this->workRespository->findBy([ "user" => $this->getUser() ]);
            // $superAdmin = in_array();

            $cards = [];
            // Users
            $cards[0]["name"] = "Usuarios";
            $cards[0]["count"] = $this->userRespository->countAll();
            $cards[0]["url"] =  "App\\Controller\\S\\Admin\\UserCrudController";

            $works = [];
            // Works
            $works[1]["name"] = "Trabajos";
            $works[1]["count"] = $this->workRespository->countAll();
            $works[1]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\TrabajoCrudController";

            // Cateogries
            $works[2]["name"] = "Categorias";
            $works[2]["count"] = $this->workCategoryRespository->countAll();
            $works[2]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\CategoryCrudController";

            // Program
            $works[3]["name"] = "Programas";
            $works[3]["count"] = $this->programRespository->countAll();
            $works[3]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\ProgramCrudController";

            // InvestigationLine
            $works[4]["name"] = "Lineas investigación";
            $works[4]["count"] = $this->investigationLineRespository->countAll();
            $works[4]["url"] = "App\\Controller\\S\\Admin\\Trabajo\\InvestigationLineCrudController";

            return $this->render('@EasyAdmin/welcome.html.twig', [
                "results" => $results,
                "cards" => $cards,
                "works" => $works,
                "isSuperAdmin" => $isSuperAdmin,
                "worksOwner" => $worksOwner,
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

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setWorkProgramRepository(ProgramRepository $programRespository)
    {
        $this->programRespository = $programRespository;
    }

    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setInvestigationLineRepository(InvestigationLineRepository $investigationLineRespository)
    {
        $this->investigationLineRespository = $investigationLineRespository;
    }
}
