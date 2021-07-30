<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles/create", name="app_admin_articles_create")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function create()
    {
        return new Response('Здесь будет страница создания статьи!');
    }

    /**
     * @Route("/admin/articles/{id}/edit", name="app_admin_articles_edit")
     * @IsGranted("MANAGE", subject="article")
     */
    public function edit(Article $article)
    {
        //if ($this->getUser() != $article->getAuthor() && !$this->isGranted("ROLE_ADMIN_ARTICLE")) {
        //    throw $this->createAccessDeniedException('Доступ запрещен');
        //}
        //$this->denyAccessUnlessGranted('MANAGE', $article);// move to annotation
        return new Response('Страница редактирования статьи' . $article->getTitle());
    }
}
