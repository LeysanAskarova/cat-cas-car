<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Это мой сайт на Symfony и, представьте себе, он на Docker!! Веу');
    }

    /**
     * @Route("/articles/{slug}")
     */
    public function show($slug)
    {
        $comments = [
            'First comment',
            'Second comment',
            'Third comment',
        ];
        return $this->render('articles/show.html.twig',//name of template
            [
                'article' => ucwords(str_replace('-',' ',$slug)),
                'comments' => $comments,
            ]// array will be used in template as parameter
         );
        /*return new Response(sprintf('Будущая страница статьи: %s',
            ucwords(str_replace('-',' ',$slug))
        ));
        */
    }
}