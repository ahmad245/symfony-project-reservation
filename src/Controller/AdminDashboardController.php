<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\DashboardService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(EntityManagerInterface $manager,DashboardService $dashboard)
    {
        
        $users=$dashboard->getUsersCount();
        $ads=$dashboard->getAdsCount();
        $reservations=$dashboard->getReservationsCount();
        $comments=$dashboard->getCommentsCount();
      
        $bestAds=$dashboard->getStatAds('DESC');
         $worstAds=$dashboard->getStatAds('ASC');                            
                                       
      
        return $this->render('admin/dashboard/index.html.twig', [
            'stats' => compact('users','ads','reservations','comments'),
            'bestAds'=>$bestAds,
            'worstAds'=>$worstAds
        ]);
    }
}
