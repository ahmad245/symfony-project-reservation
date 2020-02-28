<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments", name="admin_comments_index")
     */
    public function index(CommentRepository $comments)
    {
        return $this->render('admin/comment/index.html.twig', [
            'comments' => $comments->findAll(),
        ]);
    }

    /**
     * @Route("/admin/comment/{id}/edit",name="admin_comment_edit")
     *
     * @param Comment $comment
     * @param Request $req
     * @param EntityManagerInterface $manager
     * @return void
     */
    public function edit(Comment $comment,Request $req,EntityManagerInterface $manager){
        $form=$this->createForm(CommentType::class,$comment);
        $form->handleRequest($req);
      
        if($form->isSubmitted() && $form->isValid()){
        

            $manager->persist($comment);
            $manager->flush();
        }

     return $this->render('admin/comment/edit.html.twig',
     ['form'=>$form->createView(),'comment'=>$comment]);

    }

    /**
     * @Route("/admin/comment/{id}/delete",name="admin_comment_delete")
     */

    public function remove(Comment $comment,EntityManagerInterface $manager){
        $manager->remove($comment);
        $manager->flush();
        $this->addFlash('success','Success delete');
     
    
    return $this->redirectToRoute('admin_comments_index');
    }
}
