<?php

namespace App\Controller;



use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UtilisateurController extends AbstractController
{
    /**
     * Permet de lister et paginer les utilisateurs lié à un client connecté
     *
     * @Route("/api/utilisateurs/{page<\d+>?1}", name="liste_utilisateur", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     *
     * @param Request $request
     * @param UtilisateurRepository $repository
     * @param TokenStorageInterface $token
     * @return JsonResponse
     */
    public function liste(Request $request, UtilisateurRepository $repository, TokenStorageInterface $token)
    {
        $page = $request->get('page');

        if($page === null || $page <1){
            $page = 1;
        }

        $limit = 20;

        //recupere l'id du client
        $idClient = $token->getToken()->getUser()->getId();

        $listeTel = $repository->findAllByPageByClient($page, $limit, $idClient);
        return $this->json($listeTel,200,[],['groups'=>'liste:utilisateur']);
    }

    /**
     * @Route("/api/utilisateurs/show/{id}", name="show_utilisateur", methods={"GET"})
     * @Security("is_granted('ROLE_USER') and user === utilisateur.getClient()")
     *
     * @param Utilisateur $utilisateur
     * @return JsonResponse
     */
    public function show(Utilisateur $utilisateur){

        return $this->json($utilisateur,200,[],['groups'=>'detail:utilisateur']);
    }

    /**
     * @Route("/api/utilisateurs", name="add_utilisateur", methods={"POST"})
     *
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $manager
     * @return Response|JsonResponse
     */
    public function add(Request $request, SerializerInterface $serializer, ValidatorInterface $validator,EntityManagerInterface $manager){
        $utilisateur = $serializer->deserialize($request->getContent(), Utilisateur::class, 'json');

        $erreurs = $validator->validate($utilisateur);

        if(count($erreurs)){
            return new Response($erreurs,500, [
                'Content-type' => 'application/json'
            ]);
        }

        $manager->persist($utilisateur);
        $manager->flush();

        return new JsonResponse([
            "status" => 201,
            "message" => "l'utilisateur à bien été crée"
        ],201);
    }


    /**
     * @Route("/api/utilisateurs/{id}", name="update_utilisateur", methods={"PUT"})
     * @param Utilisateur $utilisateur
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $manager
     * @return Response|JsonResponse
     */
    public function update(Utilisateur $utilisateur, Request $request, SerializerInterface $serializer, ValidatorInterface $validator,EntityManagerInterface $manager){

        $utilisateurUpdate = $manager->getRepository(Utilisateur::class)->find($utilisateur->getId());

        $data = json_decode($request->getContent());

        foreach($data as $key => $value){
            if($key && !empty($value)){
                $name = ucfirst($key);
                $setter = 'set'.$name;
                $utilisateurUpdate->$setter($value);
            }
        }

        $erreurs = $validator->validate($utilisateurUpdate);
        if(count($erreurs)){
            $erreurs = $serializer->serialize($erreurs,'json');
            return new Response($erreurs,500, [
                'Content-type' => 'application/json'
            ]);
        }

        $manager->flush();

        return new JsonResponse([
            "status" => 200,
            "message" => "l'utilisateur à bien été mis à jour"
        ],202);
    }

    /**
     * @Route("/api/utilisateurs/{id}", name="delete_utilisateur", methods={"DELETE"})
     * @param Utilisateur $utilisateur
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Utilisateur $utilisateur, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        return new Response(null, 204);
    }
}
