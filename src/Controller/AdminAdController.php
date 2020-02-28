<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Services\PaginationService;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/ads/{page}", name="admin-ads-index" , requirements={"page":"\d+"})
     */
    public function index(AdRepository $repo,$page=1,PaginationService $pagination)
    {
        // $limit=10;
        // $start=$limit*$page-$limit;
        // $total=count($repo->findAll());
        // $pages=ceil($total / $limit) ;
        // $ads= $repo->findBy([],[],$limit,$start);
        // 'ads' => $pagination->getData(),
        // 'pages'=>$pagination->getPages(),
        // 'page'=>$page
         $pagination->setEntityClass(Ad::class)->setLimit(10)->setPage($page);

        return $this->render('admin/ad/index.html.twig', [
           'pagination'=>$pagination
        ]);
    }

    /**
     * @Route("/admin/ads/{slug}/edit",name="admin_ad_edit")
     *
     * @return void
     */
    public function edit(Ad $ad,Request $req,EntityManagerInterface $manager){
        $form=$this->createForm(AdType::class,$ad);
        $form->handleRequest($req);
      
        if($form->isSubmitted() && $form->isValid()){
         foreach ($ad->getImages() as $image) {
             $image->setAd($ad);
             $manager->persist($image);
         }

            $manager->persist($ad);
            $manager->flush();
        }

     return $this->render('admin/ad/edit.html.twig',
     ['form'=>$form->createView(),'ad'=>$ad]);
    }

    /**
     * @Route("/admin/ads/{id}/delete",name="admin_ad_delete")
     *
     * @return void
     */
    public function remove(Ad $ad,EntityManagerInterface $manager){
        if(count($ad->getBookings()) > 0){
            $this->addFlash('warning','you can not delete ad was reservied');
        }
        else{
            $manager->remove($ad);
            $manager->flush();
         
        }
        return $this->redirectToRoute('admin-ads-index');
    }
}
