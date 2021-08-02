<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

/*
* @method User|null getUser() 
*/
class ArticlesController extends AbstractController
{
    /**
     * @Route("/admin/articles", name="app_admin_articles")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function index(PaginatorInterface $paginator, ArticleRepository $articleRepository, Request $request)
    {
        $pagination = $paginator->paginate(
            $articleRepository->latest(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/articles/index.html.twig', ['pagination'=>$pagination]);
    }

    /**
     * @Route("/admin/articles/create", name="app_admin_articles_create")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();
            $article->setPublishedAt(new \DateTime())
            ;
            $em->persist($article);
            $em->flush();    

            $this->addFlash('flash_message', 'Статья успешно создана');

            return $this->redirectToRoute('app_admin_articles');
        }
        return $this->render('admin/articles/create.html.twig', ['articleForm'=>$form->createView()]);
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
