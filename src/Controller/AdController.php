<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\AdLike;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdLikeRepository;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AdController extends AbstractController
{
   
    /**
     * @Route("/ads", name="ad-index")
     */
    public function index(AdRepository $repo)
    {
       $ads=$repo->findAll();
       
        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
            'ads'=>$ads
        ]);
    }

    /**
     * @Route("/ads/create",name="ad-create")
     * @IsGranted("ROLE_EDITER")
     */
    public function create(Request $req,EntityManagerInterface   $manager){
         $ad=new Ad();

      
        
        $form=$this->createForm(AdType::class,$ad);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }
            $ad->setAuthor($this->getUser());
            $manager->persist($ad);
            $manager->flush();
            return $this->redirectToRoute('ad-show',['slug'=>$ad->getSlug()]);
        }
        return $this->render('ad/create.html.twig',['form'=>$form->createView()]);                         
    }

    /**
     * @Route("/ads/{slug}/edit",name="ad-edit")
     * @Security("is_granted('ROLE_EDITER') or (is_granted('ROLE_USER') and user===ad.getAuthor())")
     * @param Ad $ad
     * @param Request $req
     * @param EntityManagerInterface $manager

     */
    public function edit(Ad $ad,Request $req,EntityManagerInterface   $manager){
     $form=$this->createForm(AdType::class,$ad);
       $form->handleRequest($req);
       if($form->isSubmitted() && $form->isValid()){
        foreach($ad->getImages() as $image){
            $image->setAd($ad);
            $manager->persist($image);
        }
        $manager->persist($ad);
        $manager->flush();
        return $this->redirectToRoute('ad-show',['slug'=>$ad->getSlug()]);
    }
    return $this->render('ad/edit.html.twig',['form'=>$form->createView()]);   

}
    /**
     * 
     *@Route("/ads/{slug}" , name="ad-show")

     * @param Ad $ad
     * @return void
     * 
     */
    public function show($slug,AdRepository $repo){
        $ad=$repo->findOneBySlug($slug);
        $ad->getNotAvailableDays();
        return $this->render('ad/show.html.twig',['ad'=>$ad]);
    }
    /**
     * @Route("/ad/{slug}/delete", name="ad-delete")
     * @Security("is_granted('ROLE_EDITER') or (is_granted('ROLE_USER') and user===ad.getAuthor())")
     * @param Ad $ad
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function remove(Ad $ad,EntityManagerInterface $manager){
        $manager->remove($ad);
        $manager->flush();
     return $this->redirectToRoute('ad-index');
    }

   /**
    * Undocumented function
    *@Route("/ad/{id}/like", name="ad_like")
    * @param Ad $ad
    * @param AdLikeRepository $adLike
    * @param EntityManagerInterface $manager
    * @return Response
    */
    public function like(Ad $ad ,AdLikeRepository $adLike,EntityManagerInterface $manager) : Response{
        $user=$this->getUser();

        // verify user 
        if(!$user) return $this->json([
            'code'=>403,
             'message'=>'not authorized'
        ],403);

        // if is liked will removed
       if($ad->isLikedByUser($user)){
          $like= $adLike->findOneBy(['ad'=>$ad,'user'=>$user]);
          $manager->remove($like);
          $manager->flush();

          return $this->json([
              'code'=>200,
              'message'=>'has been removed',
              'likes'=>$adLike->count(['ad'=>$ad])],200);
       }

        // if is dont  liked will added
       $like=new AdLike();
       $like->setAd($ad)->setUser($user);
       $manager->persist($like);
       $manager->flush();

       return $this->json([
        'code'=>200,
        'message'=>'has been added',
        'likes'=>$adLike->count(['ad'=>$ad])],200);

    }
}

  // $image=new Image();
        // $image->setUrl('http:/placehold.it/400x200');
        // $image->setCaption('first image');

        // $ad->addImage($image);

// https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/bootstrap_4_layout.html.twig

// $form=$this->createFormBuilder($ad)
// ->add('title')
// ->add('description')
// ->add('coverImage')
// ->add('solid')
// ->add('price')
// ->add('startDate')
// ->add('endDate')
// ->add('content')
// ->add('publish')
// ->add('slug')
// ->add('location')
// ->getForm();