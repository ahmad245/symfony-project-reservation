<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;

class PaginationService{
   private $limit=10;
   private $page;
   private $entityClass;
   private $manager;
   private $twig;
   private $req;
   private $templatePath;
   public function __construct(EntityManagerInterface $manager,Environment $twig,RequestStack $req,$templatePath)
   {
       $this->manager=$manager;
       $this->twig=$twig;
       $this->req=$req->getCurrentRequest()->attributes->get('_route');
       $this->templatePath=$templatePath;
   }

   public function display(){
      $this->twig->display( $this->templatePath,[
         'page'=>$this->getPage(),
         'pages'=>$this->getPages(),
        'route'=>$this->req
      ]);
   }
   public function getData(){
      if(empty($this->entityClass)){
         throw new  \Exception('you must to enter entity');
      }
     $offset=$this->page * $this->limit -$this->limit ;
     $data=$this->manager->getRepository($this->entityClass)->findBy([],[],$this->limit,$offset);
     return $data;
   }

   public function getPages(){
      if(empty($this->entityClass)){
         throw new  \Exception('you must to enter entity');
      }
       $total=count($this->manager->getRepository($this->entityClass)->findAll());
       return ceil($total / $this->limit);
   }

   /**
    * Get the value of page
    */ 
   public function getPage()
   {
      return $this->page;
   }

   /**
    * Set the value of page
    *
    * @return  self
    */ 
   public function setPage($page)
   {
      $this->page = $page;

      return $this;
   }

   /**
    * Get the value of entityClass
    */ 
   public function getEntityClass()
   {
      return $this->entityClass;
   }

   /**
    * Set the value of entityClass
    *
    * @return  self
    */ 
   public function setEntityClass($entityClass)
   {
      $this->entityClass = $entityClass;

      return $this;
   }

   /**
    * Get the value of limit
    */ 
   public function getLimit()
   {
      return $this->limit;
   }

   /**
    * Set the value of limit
    *
    * @return  self
    */ 
   public function setLimit($limit)
   {
      $this->limit = $limit;

      return $this;
   }

   /**
    * Get the value of templatePath
    */ 
   public function getTemplatePath()
   {
      return $this->templatePath;
   }

   /**
    * Set the value of templatePath
    *
    * @return  self
    */ 
   public function setTemplatePath($templatePath)
   {
      $this->templatePath = $templatePath;

      return $this;
   }
}