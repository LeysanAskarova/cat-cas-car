<?php
namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use App\Entity\User;

class UsersController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/users", name="users")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository(User::class)->findAll();
        if ($restresult === null) {
          return new View("there are no users exist", Response::HTTP_NOT_FOUND);
     }
        return $restresult;
    }

    /**
    * @Rest\Get("/users/{id}")
    */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository(User::class)->find($id);
        if ($singleresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }
}