<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\S\Core;

use App\Controller\Controller;
use App\Repository\M\Master\TermRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Maximosojo\ToolsBundle\Model\Paginator\Paginator;
use App\Entity\M\Master\Term;

/**
 * Controlador de selects por ajax (privadp)
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[Route(path: '/core/select')]
class SelectController extends Controller
{
    /**
     * @Route("/master/term/data.json", name="app_route_session_core_term_data", defaults={"_format":"json"},methods="GET")
     */
    public function masterTermData(Request $request, TermRepository $termRepository)
    {
        $view = $this->view();
        $criteria = $request->get("filter",[]);
        $criteria["name"] = $request->get("q");
        $criteria["taxonomy"] = $request->get("taxonomy");
        $criteria["parent"] = $request->get("parent");
        $paginator = $termRepository->createPaginator($criteria,["name" => "ASC"]);
        $view->setData($this->buildData($request, $paginator));
        return $this->handleView($view);
    }
}