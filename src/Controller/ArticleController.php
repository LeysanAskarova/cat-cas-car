<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController 
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Это мой сайт на Symfony');
    }

    /**
     * @Route("/articles/{slug}")
     */
    public function show($slug)
    {
        return new Response(sprintf('Будущая страница статьи: %s',
            ucwords(str_replace('-',' ',$slug))
        ));
    }
}