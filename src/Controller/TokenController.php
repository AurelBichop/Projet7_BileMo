<?php

namespace App\Controller;

use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Swagger\Annotations as SWG;
use App\Entity\Token;

/**
 * Class TokenController
 * @SWG\Tag(name="Connexion Client (Token)")
 * @package App\Controller
 */
class TokenController extends AbstractController
{
    /**
     * @Route("/api/login_check", name="apiBileMo_login_check", methods={"POST"})
     *
     * @SWG\Parameter(
     *     name="Login Client",
     *     in="body",
     *     required=true,
     *     description="Demande de token",
     *     @Model(type=Token::class)
     * )
     * @SWG\Response(
     *     response=200,
     *     description="Retourne un Token poour se connecter",
     *     )
     * @SWG\Response(
     *     response=401,
     *     description="mauvais identifiant ou mot de passe",
     *     )
     */
    public function loginCheck()
    {

    }
}
