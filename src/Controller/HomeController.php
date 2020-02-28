<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController 
{
    private $arr=['name'=>'ahmad','age'=>33,'email'=>'ahmad@gmail.com'];
    private $arr2=[1,2,3,10,15,10,20,30,100];
    
 
    /**
     *@Route("/hello/{name}",name="hello_base")
     *@Route("/hello")
     */
    public function hello($name="world"){
       return new  Response('hello'.$name);
    }
    /**
     * @Route("/",name="homePage")
     */
    
    public function home(AdRepository $adRepository){
        return $this->render('home.html.twig',
        [
         'ads'=>$adRepository->getBestAds()
        ]);
    }
}
