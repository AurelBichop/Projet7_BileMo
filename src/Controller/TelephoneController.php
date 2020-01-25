<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Telephone;
use App\Repository\TelephoneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TelephoneController extends AbstractController
{
    /**
     * @Route("/api/telephones/{page<\d+>?1}", name="liste_telephone", methods={"GET"})
     * @param Request $request
     * @param TelephoneRepository $repository
     * @return JsonResponse
     */
    public function liste(Request $request, TelephoneRepository $repository)
    {
        $page = $request->get('page');

        if($page === null || $page <1){
            $page = 1;
        }

        $limit = 20;

        $listeTel = $repository->findAllByPage($page, $limit);
        return $this->json($listeTel,200,[],['groups'=>'liste:tel']);
    }

    /**
     * @Route("/api/telephones/show/{id}", name="show_telephone", methods={"GET"})
     * @param Telephone $telephone
     * @return JsonResponse
     */
    public function show(Telephone $telephone){

        return $this->json($telephone,200,[],['groups'=>'detail:tel']);
    }


    /**
     * @Route("/api/marque/show/{id}", name="show_marque", methods={"GET"})
     * @param Marque $marque
     * @return JsonResponse
     */
    public function showMarque(Marque $marque){

        return $this->json($marque,200,[],['groups'=>'detail:marque']);
    }
}
