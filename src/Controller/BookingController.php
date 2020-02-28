<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\BookingType;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
  /**
   * @Route("ads/{slug}/booking", name="booking_index")
   * @Security("is_granted('ROLE_EDITER')")
   */
  public function index(Ad $ad, Request $req, EntityManagerInterface $manager)
  {
    $booking = new Booking();
    $success = "true";
    $form = $this->createForm(BookingType::class, $booking);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      $booking->setAd($ad);
      $booking->setUser($this->getUser());
      $booking->setDateCreate(new \DateTime());
      $diff = $booking->getEndDate()->diff($booking->getStartDate());
      $booking->setAmount($diff->days * $ad->getPrice());
      if (!$booking->isAvailable()) {
        $success = "false";
      } else {
        $manager->persist($booking);
        $manager->flush();
        return $this->redirectToRoute(
          'booking_show',
          [
            'id' => $booking->getId(),
            'withAlert' => true
          ]
        );
      }
    }
    return $this->render('booking/index.html.twig', [
      'form' => $form->createView(),
      'ad' => $ad,
      'success' => $success
    ]);
  }
  /**
   * @Route("/booking/{id}",name="booking_show")
   */
  public function book(Booking $booking, Request $req, EntityManagerInterface $manager)
  {
    $comment = new Comment();
    $form = $this->createForm(CommentType::class, $comment);
    $form->handleRequest($req);
    if ($form->isSubmitted() && $form->isValid()) {
      $comment->setAd($booking->getAd());
      $comment->setUser($this->getUser());
      $manager->persist($comment);
      $manager->flush();
    }


    return $this->render('booking/booking_success.html.twig',
     ['booking' => $booking,
     'form'=>$form->createView()]);
  }
}
