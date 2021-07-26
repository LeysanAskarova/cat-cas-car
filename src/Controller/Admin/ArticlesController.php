<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
