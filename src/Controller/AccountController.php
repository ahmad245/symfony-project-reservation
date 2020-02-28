<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Form\RegisterType;
use App\Entity\UpdatePassword;
use App\Form\UpdatePasswordType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $util)
    {
        $error = $util->getLastAuthenticationError();

        return $this->render('account/login.html.twig', ['error' => $error]);
    }
    /**
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {
    }

    /**
     * @Route("/register",name="account_register")
     */
    public function register(Request $req, EntityManagerInterface $manager, UserPasswordEncoderInterface $encode)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($encode->encodePassword($user, $user->getPassword()));
            $manager->persist($user);
            $manager->flush();
        }
        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/profile",name="account_profile")
     * @Security("is_granted('ROLE_USER')")
     */

     public function profile(Request $req,EntityManagerInterface $manager){

        $form=$this->createForm(AccountType::class,$this->getUser());
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($this->getUser());
            $manager->flush();
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);

     }

     /**
      * @Route("/account/password-update",name="password-update")
      * @Security("is_granted('ROLE_USER')")
      */
      public function updataPassword(Request $req,EntityManagerInterface $manager,UserPasswordEncoderInterface $encode)
      {
        $password=new UpdatePassword();
        $user=$this->getUser();
        $form=$this->createForm(UpdatePasswordType::class,$password);
        $form->handleRequest($req);
        if ($form->isSubmitted() && $form->isValid()) {
           if(!password_verify($password->getOldPassword(),$user->getPassword())){
               $form->get('oldPassword')->addError(new FormError('password erorr'));
           }
           else{
               
               $user->setPassword($encode->encodePassword($user,$password->getNewPassword()));
               $manager->persist($user);
               $manager->flush();
               return $this->redirectToRoute('homePage');

           }

           
        }
        return $this->render('account/updatePassword.html.twig', [
            'form' => $form->createView()
        ]);

      }
 
      /**
      
       *@Route("/account",name="account_index")
      * @Security("is_granted('ROLE_USER')")
       */
      public function myAccount(){
       return $this->render('user/show.html.twig',[
           'user'=>$this->getUser()
       ]);
      }

      /**
       * Undocumented function
       *@Route("/account/myBooking",name="myBooking_index")
       * @return Response
       */
      public function myBooking(){
         return $this->render('account/booking.html.twig');
      }
}
