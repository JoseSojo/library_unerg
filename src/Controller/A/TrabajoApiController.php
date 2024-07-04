<?php

namespace App\Controller\A;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Maximosojo\ToolsBundle\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\M\Trabajo\TrabajoRepository;
use App\Repository\M\User\UserRepository;
use App\Repository\M\Master\Trabajo\CategoryRepository;
use App\Repository\M\Master\Trabajo\InvestigationLineRepository;
use App\Repository\M\Master\Trabajo\ProgramRepository;
use Maximosojo\Bundle\BaseAdminBundle\Controller\EasyAdminBundle\AbstractDashboardController;

class TrabajoApiController extends AbstractDashboardController
{
    private $trabajo;
    private $category;
    private $investigationLine;
    private $program;
    private $user;

    public function __construct(
        TrabajoRepository $trabajo, CategoryRepository $categoryRepository,
        InvestigationLineRepository $investigationLineRepository, ProgramRepository $programRepository,
        UserRepository $userRepository
    )
    {
        $this->trabajo = $trabajo;
        $this->investigationLine = $investigationLineRepository;
        $this->category = $categoryRepository;
        $this->program = $programRepository;
        $this->user = $userRepository;
    }

    #[Route('/trabajo/category/counts', methods: ['GET'], name: 'app_route_api_work_category_count', defaults: ['_format' => 'json'])]
    public function countCategory(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $result = [];

        $category = $this->category->findAll();

        $result["category"] = [];
        foreach ($category as $key) {
            $valueResponse = [];
            $valueResponse['name'] = $key->getName();
            $valueResponse['id'] = $key->getId();
            $valueResponse['count'] = $this->trabajo->count([ 'category'=>$key ]);
            
            array_push($result["category"], $valueResponse);
        }

        $jsonContent = $serializer->serialize($result, 'json');

        return new Response(
            $jsonContent,
            Response::HTTP_OK,
            array('content-type' => 'aplication/json')
        );
    }

    #[Route('/trabajo/programs', methods: ['GET'], name: 'app_route_api_work_programs', defaults: ['_format' => 'json'])]
    public function getPrograms(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $result = [];

        $programs = $this->program->findAll();

        $result["programs"] = $programs;

        $jsonContent = $serializer->serialize($result, 'json');
        return new Response(
            $jsonContent,
            Response::HTTP_OK,
            array('content-type' => 'aplication/json')
        );
    }

    #[Route('/trabajo/investigationline', methods: ['GET'], name: 'app_route_api_work_investigation_line', defaults: ['_format' => 'json'])]
    public function getInvestigationLine(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $result = [];

        $investigationLine = $this->investigationLine->findAll();

        $result["investigationLine"] = $investigationLine;

        $jsonContent = $serializer->serialize($result, 'json');
        return new Response(
            $jsonContent,
            Response::HTTP_OK,
            array('content-type' => 'aplication/json')
        );
    }

    #[Route('/trabajo', methods: ['GET'], name: 'app_route_api_work', defaults: ['_format' => 'json'])]
    public function getWorks(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $result = [];

        $limit = $request->get('limit');
        if(!$limit) {
            $limit = 15;
        }
        $offset = $request->get('offset');
        if(!$offset) {
            $offset = 0;
        }
        $category = $request->get('category');
        $investigationLine = $request->get('investigationLine');
        $program = $request->get('program');

        $filter = [];

        $filter["public"] = true;

        $author = $request->get('author');
        $text = $request->get('text');

        if($text) {
            $filter["title"] = $text;
            $filter["resumenText"] = $text;
        }

        $userWork = null;
        if($author) $userWork = $this->user->GetUserByParam($author);
        $categoryWork = $this->category->findOneBy([ "name"=>$category ]);
        $investigationLineWork = $this->investigationLine->findOneBy([ "name"=>$investigationLine ]);
        $programWork = $this->program->findOneBy([ "name"=>$program ]);
        $programWork = $this->program->findOneBy([ "name"=>$program ]);

        if($categoryWork) $filter["category"] = $categoryWork;
        if($investigationLineWork) $filter["investigationLine"] = $investigationLineWork;
        if($programWork) $filter["program"] = $programWork;
        if($userWork) $filter["user"] = $userWork;

        $count = $this->trabajo->count($filter);
        $works = $this->trabajo->findBy($filter, null, $limit, $offset*$limit);

        $result["filter"] = $filter;
        $result["count"] = $count;
        $result["works"] = $works;

        $jsonContent = $serializer->serialize($result, 'json');
        return new Response(
            $jsonContent,
            Response::HTTP_OK,
            array('content-type' => 'aplication/json')
        );
    }

    #[Route('/trabajo/recent', methods: ['GET'], name: 'app_route_api_work_recent', defaults: ['_format' => 'json'])]
    public function getWorksRecientes(Request $request)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $result = [];

        $works = $this->trabajo->findRecendWork();

        $result["works"] = $works;

        $jsonContent = $serializer->serialize($result, 'json');
        return new Response(
            $jsonContent,
            Response::HTTP_OK,
            array('content-type' => 'aplication/json')
        );
    }
}
