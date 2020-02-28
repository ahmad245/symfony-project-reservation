<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/user/{slug}", name="user_show")
    * @Security("is_granted('ROLE_USER')")
     */
    public function index(User $user)
    {
        return $this->render('user/show.html.twig', [
            'user' => $user
        ]);
    }
}
