<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN_ARTICLE")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/article/create", name="app_admin_articles_create")
     */
    public function create(): Response
    {
        return new Response('Здесь будет страница создания статьи!');
    }
}
