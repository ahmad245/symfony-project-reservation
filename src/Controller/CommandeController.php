<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\Ad;
use App\Entity\AdLike;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdLikeRepository;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Symfony\Component\HttpFoundation\Response;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande/{anne}/{moi}", name="commande_index")
     */
    public function index($anne=null ,$moi=null )
    {

        return $this->render('commande/index.html.twig', [
           'anne'=>$anne,
           'moi'=>$moi
        ]);
    }
}
