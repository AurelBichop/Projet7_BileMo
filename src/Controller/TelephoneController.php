<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Entity\Telephone;
use App\Repository\TelephoneRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelephoneController extends AbstractController
{
    /**
     * Retourne une liste des telephones
     *
     * @Route("/api/telephones/{page<\d+>?1}", name="liste_telephone", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Retourne une liste des telephones",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Telephone::class, groups={"liste:tel"}))
     *     )
     * )
     * @SWG\Tag(name="Telephones")
     * @Security(name="Bearer")
     *
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
        return $this->json($listeTel,Response::HTTP_OK,[],['groups'=>'liste:tel']);
    }

    /**
     * Retourne le détail d'un téléphone
     *
     * @Route("/api/telephones/show/{id}", name="show_telephone", methods={"GET"})
     * @SWG\Response(
     *     response=200,
     *     description="Retourne le détail d'un téléphone",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Telephone::class, groups={"detail:tel"}))
     *     )
     * )
     * @SWG\Tag(name="Telephones")
     * @Security(name="Bearer")
     *
     * @param Telephone $telephone
     * @return JsonResponse
     */
    public function show(Telephone $telephone){

        return $this->json($telephone,Response::HTTP_OK,[],['groups'=>'detail:tel']);
    }


    /**
     * Retourne le détail de la marque ainsi que les téléphones lui correspondant
     *
     * @Route("/api/marque/show/{id}", name="show_marque", methods={"GET"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Retourne le détail de la marque ainsi que les téléphones lui correspondant",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=Marque::class, groups={"detail:marque"}))
     *     )
     * )
     * @SWG\Tag(name="Marques")
     *
     * @Security(name="Bearer")
     * @param Marque $marque
     * @return JsonResponse
     */
    public function showMarque(Marque $marque){

        return $this->json($marque,Response::HTTP_OK,[],['groups'=>'detail:marque']);
    }
}
