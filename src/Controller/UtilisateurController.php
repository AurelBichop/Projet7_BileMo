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
     * Permet de lister et paginer ses utilisateurs
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
        // Gestion de la pagination ::::::::
        $page = $request->get('page');
        if($page === null || $page <1){
            $page = 1;
        }
        $limit = 20;
        //:::::::::::::::::::::::::::::::::::

        //recupere l'id du client
        $idClient = $token->getToken()->getUser()->getId();
        $listeUtilisateur = $repository->findAllByPageByClient($page, $limit, $idClient);

        return $this->json($listeUtilisateur,Response::HTTP_OK,[],['groups'=>'liste:utilisateur']);
    }

    /**
     * Permet de voir les details d'un utilisateurs
     *
     * @Route("/api/utilisateurs/show/{id}", name="show_utilisateur", methods={"GET"})
     * @Security("is_granted('ROLE_USER') and user === utilisateur.getClient()")
     *
     * @param Utilisateur $utilisateur
     * @return JsonResponse
     */
    public function show(Utilisateur $utilisateur){

        return $this->json($utilisateur,Response::HTTP_OK,[],['groups'=>'detail:utilisateur']);
    }

    /**
     * Ajout d'un nouvelle utilisateur
     *
     * @Route("/api/utilisateurs", name="add_utilisateur", methods={"POST"})
     *
     * @param Request $request
     * @param TokenStorageInterface $token
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $manager
     * @return Response|JsonResponse
     */
    public function add(Request $request, TokenStorageInterface $token, SerializerInterface $serializer, ValidatorInterface $validator,EntityManagerInterface $manager){
        //recupere le client
        $client = $token->getToken()->getUser();
        //récupération des informations et desiarilisation
        $utilisateur = $serializer->deserialize($request->getContent(), Utilisateur::class, 'json');
        $utilisateur->setClient($client);

        //gestion des erreurs de validations
        $erreurs = $validator->validate($utilisateur);

        if(count($erreurs)){
            return new Response($erreurs,Response::HTTP_CONFLICT, [
                'Content-type' => 'application/json'
            ]);
        }

        $manager->persist($utilisateur);
        $manager->flush();

        return new JsonResponse([
            "status" => 201,
            "message" => "l'utilisateur à bien été crée"
        ],Response::HTTP_CREATED);
    }


    /**
     * Mise à jour d'un utilisateur
     *
     * @Route("/api/utilisateurs/{id}", name="update_utilisateur", methods={"PUT"})
     * @Security("is_granted('ROLE_USER') and user === utilisateur.getClient()")
     *
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
            return new Response($erreurs,Response::HTTP_CONFLICT, [
                'Content-type' => 'application/json'
            ]);
        }

        $manager->flush();

        return new JsonResponse([
            "status" => 200,
            "message" => "l'utilisateur à bien été mis à jour"
        ],Response::HTTP_OK);
    }

    /**
     * Suppression d'un utilisateur
     *
     * @Route("/api/utilisateurs/{id}", name="delete_utilisateur", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER') and user === utilisateur.getClient()")
     *
     * @param Utilisateur $utilisateur
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function delete(Utilisateur $utilisateur, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($utilisateur);
        $entityManager->flush();
        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
