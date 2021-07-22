<?php

namespace App\Controller\Admin;

use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="app_admin_comments")
     */
    public function index(Request $request): Response
    {
        $comments = [
            [
                'articleTitle' => 'first article',
                'comment' => 'first comment',
                'createdAt' => new \DateTime('-1 hours'),
                'authorName' => 'first name'
            ],
            [
                'articleTitle' => 'second article',
                'comment' => 'second comment',
                'createdAt' => new \DateTime('-1 days'),
                'authorName' => 'second name'
            ],
            [
                'articleTitle' => 'third article',
                'comment' => 'third comment',
                'createdAt' => new \DateTime('-11 days'),
                'authorName' => 'third name'
            ],
            [
                'articleTitle' => 'fouth article',
                'comment' => 'fouth comment',
                'createdAt' => new \DateTime('-35 hours'),
                'authorName' => 'fouth name'
            ],
        ];

        $q = $request->query->get('q');
        if($q) {
            $comments = array_filter($comments, function($comment) use ($q) {
                return stripos($comment['comment'], $q) !== false;
            });
        }
        return $this->render('admin/comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }
}
