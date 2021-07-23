<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/article/create", name="app_admin_articles_create")
     */
    public function create(EntityManagerInterface $em): Response
    {
        $article = new Article();
        $article
            ->setTitle('Есть ли жизнь после девятой жизни?')
            ->setSlug('is-there-life-after-ninth-life' . rand(100, 999))
            ->setBody('Lorem ipsum **красная точка** dolor sit amet, consectetur adipiscing elit, sed
            do eiusmod tempor incididunt [Сметанка](/) ut labore et dolore magna aliqua.
            Purus viverra accumsan in nisl. Diam vulputate ut pharetra sit amet aliquam. Faucibus a
            pellentesque sit amet porttitor eget dolor morbi non. Est ultricies integer quis auctor
            elit sed. Tristique nulla aliquet enim tortor at. Tristique et egestas quis ipsum. Consequat semper viverra nam
            libero. Lectus quam id leo in vitae turpis. In eu mi bibendum neque egestas congue
            quisque egestas diam. **Красная точка** blandit turpis cursus in hac habitasse platea dictumst quisque.');
        
        $article
            ->setAuthor('Article Author')
            ->setImageFilename('car1.jpg')
            ->setLikeCount(rand(0, 10));

            if(rand(1,10) > 4) {
                $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(0,50))));
            }

            $em->persist($article);
            $em->flush();

            return new Response(
                sprintf('создана статься id: %d slug: %s', $article->getId(),$article->getSlug())
            );
    }
}
