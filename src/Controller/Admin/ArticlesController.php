<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
    public function create(EntityManagerInterface $em, Request $request, FileUploader $articleFileUploader)
    {
        $form = $this->createForm(ArticleFormType::class, new Article());
        if($article = $this->handleFormRequest($form, $em, $request, $articleFileUploader)) {
            $this->addFlash('flash_message', 'Статья успешно создана');
            return $this->redirectToRoute('app_admin_articles');
        }
        return $this->render('admin/articles/create.html.twig', [
            'articleForm'=>$form->createView(),
            'showError'=>$form->isSubmitted(),
        ]);
    }

    /**
     * @Route("/admin/articles/{id}/edit", name="app_admin_articles_edit")
     * @IsGranted("MANAGE", subject="article")
     */
    public function edit(
        Article $article, 
        EntityManagerInterface $em, 
        Request $request,
        FileUploader $articleFileUploader
    ) {
        //if ($this->getUser() != $article->getAuthor() && !$this->isGranted("ROLE_ADMIN_ARTICLE")) {
        //    throw $this->createAccessDeniedException('Доступ запрещен');
        //}
        //$this->denyAccessUnlessGranted('MANAGE', $article);// move to annotation
        $form = $this->createForm(ArticleFormType::class, $article, [
            'enabled_published_at'=>true
        ]);
        if($article = $this->handleFormRequest($form, $em, $request, $articleFileUploader)) {
            $this->addFlash('flash_message', 'Статья успешно изменена');
            return $this->redirectToRoute('app_admin_articles_edit', ['id'=>$article->getId()]);
        }

        return $this->render('admin/articles/edit.html.twig', [
            'articleForm'=>$form->createView(),
            'showError'=>$form->isSubmitted(),
        ]);
    }

    private function handleFormRequest(
        FormInterface $form, 
        EntityManagerInterface $em, 
        Request $request,
        FileUploader $articleFileUploader
    ) {
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            /** @var Article $article */
            $article = $form->getData();

            /** @var UploadedFile|null $image */
            $image = $form->get('image')->getData();

            if($image) {
                $article->setImageFilename($articleFileUploader->uploadFile($image));
            }

            $em->persist($article);
            $em->flush();    

            return $article;
        }
        return null;
    }
}
