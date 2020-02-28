<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use App\Entity\AdLike;
use App\Entity\Booking;
use App\Entity\Comment;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $faker;
    private $manager;
    private $users=[];
    private $rolesArr=[];
    protected $encode;

    public function __construct(UserPasswordEncoderInterface $encode)
    {
         $this->encode=$encode;
    }
    public function load(ObjectManager $manager)
    {
       
        $this->manager = $manager;
        $this->faker = Factory::create('FR-fr');
        $this->roles();
        $this->user();
        $this->ads();
    }

    public function ads()
    {
        for ($i = 0; $i <= 30; $i++) {
            $ad = new Ad();
            $title = $this->faker->sentence();
            $description = $this->faker->realText(rand(10, 50));
            $content = $this->faker->realText(rand(10, 2000));
            $publish = $this->faker->boolean;
            $location = $this->faker->sentence();
            $startDate = $this->faker->dateTime();
            $endDate = $this->faker->dateTime();
            $coverImage=$this->faker->imageUrl(1000,350);

       
            $ad->setTitle($title)->setPublish($publish)
            ->setLocation($location)
            ->setDescription($description)
            ->setContent($content)
            ->setStartDate($startDate)
            ->setEndDate($endDate)
            ->setPrice(rand(40, 200))
            ->setCoverImage($coverImage)
            ->setSolid(rand(1, 100))
            ->setAuthor($this->users[rand(0,count($this->users)-1)]);
            for ($j = 0; $j <= rand(2, 5); $j++) {
                $image = new Image();
                $image->setUrl($this->faker->imageUrl())->setCaption($this->faker->sentence())
                    ->setAd($ad);
                //    $ad->addImage($image);
                $this->manager->persist($image);
            }
          
           
            $this->manager->persist($ad);
            for ($l=0; $l < rand(1, 10); $l++) { 
                $like=new AdLike();
                $like->setAd($ad);
                $like->setUser($this->users[rand(0,count($this->users)-1)]);
                $this->manager->persist($like);
              }
            $this->booking($ad);
        }
        $this->manager->flush();
    }

    public function user(){
        $roles=['ROLE_USER','ROLE_ADMIN','ROLE_SUPERADMIN','ROLE_WRITER','ROLE_EDITER'];
         for ($i=0; $i <= 10; $i++) { 
            $user=new User();
           
            $user->setFirstName($this->faker->firstname);
            $user->setLastName($this->faker->lastname);
            $user->setEmail($this->faker->email);
            $user->setIntroduction($this->faker->sentence());
            $user->setBio($this->faker->realText(rand(10, 400)));
            $user->setPicture($this->faker->imageUrl(1000,350));

            $hash=$this->encode->encodePassword($user,'Syria245!');

            $user->setPassword($hash);

            $user->addUserRole($this->rolesArr[rand(0,4)]);
            $this->manager->persist($user);
          
            $this->users[]=$user;
         }
         $this->manager->flush();

    }

    public function roles(){
        $roles=['ROLE_USER','ROLE_ADMIN','ROLE_SUPERADMIN','ROLE_WRITER','ROLE_EDITER'];
        for ($i=0; $i <= 4; $i++) { 

        $role=new Role();
        $role->setName($roles[$i]);
        $this->rolesArr[]=$role;
        $this->manager->persist($role);
     }
     $this->manager->flush();
        
    }
    public function booking($ad){
        for ($i=0; $i < rand(0,10); $i++) { 
           
            $book=new Booking();

            $dateCreate=$this->faker->dateTimeBetween('-6 months');
            $startDate=$this->faker->dateTimeBetween('-3 months');
            $duration=rand(3,10);
    
            $endDate=(clone $startDate)->modify("+$duration days");
    
            $amount=$ad->getPrice()*$duration;
            $user=$this->users[rand(0,count($this->users)-1)];
            
            $book->setDateCreate($dateCreate)
                  ->setStartDate($startDate)
                  ->setEndDate($endDate)
                  ->setAmount($amount)
                  ->setAd($ad)
                  ->setUser($user);
                  
    
             $this->manager->persist($book);
         
             if(rand(0,1)){
               $this->comment($ad,$user);
             }

             $this->manager->flush();
        }


    }
    public function comment($ad,$user){
     $comment=new Comment();
     $comment->setContent( $this->faker->realText(rand(10, 400)));
     $comment->setRating(rand(1,5));
     $comment->setUser($user);
     $comment->setAd($ad);
     $this->manager->persist($comment);
     $this->manager->persist($comment);
    }
}
