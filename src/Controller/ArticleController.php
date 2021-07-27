<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Service\SlackClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository)
    {
        $articles = $repository->findLatestPublished();
        return $this->render('articles/homepage.html.twig', ['articles' => $articles]);
    }

    /**
     * @Route("/articles/{slug}" , name="app_article_show")
     */
    public function show(Article $article,
                         SlackClient $slackClient
    )
    {
        if ($article->getSlug() == 'slack') {
            $slackClient->send('Привет это важное уведомление');
        }

        return $this->render('articles/show.html.twig',//name of template
            [
                'article' => $article
            ]// array will be used in template as parameter
        );
    }
}