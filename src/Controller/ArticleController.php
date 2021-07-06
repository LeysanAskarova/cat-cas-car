<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        return $this->render('articles/homepage.html.twig');
    }

    /**
     * @Route("/articles/{slug}" , name="app_article_show")
     */
    public function show($slug)
    {
        $comments = [
            'First comment',
            'Second comment',
            'Third comment',
        ];
        //dd($slug, $this);
        dump($slug, $this);
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