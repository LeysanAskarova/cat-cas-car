<?php

namespace App\Controller\Api;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/api/user", name="api_user")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function index(UserRepository $repository): Response
    {
        return $this->json($repository->findAll(), 200, [], ['groups' => ['main']]);
    }
}
